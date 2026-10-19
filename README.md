# Spatie: Laravel Activitylog Package

## Instalação

Para a instalação é preciso rodar `composer require spatie/laravel-activitylog`, assim as classes do pacote serão colocadas no projeto.

Depois disso, é necessário obter os arquivos referentes às migrations e às configurações. Isso é feito através do comando `php artisan vendor:publish --provider="<provedor>" --tag="<arquivo>"`.

> **NOTA:** É preciso executar as migrations depois de importar os arquivos externos!

Utilizamos os seguintes parâmetros:

- **Provedor:** `Spatie\Activitylog\ActivitylogServiceProvider`
- **Tag da Migration:** `activitylog-migrations`
- **Tag da Configuração:** `activitylog-config`

Na prática:

```bash
composer require spatie/laravel-activitylog

php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"

php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-config"

php artisan migrate
```

## Uso Básico

Em sua forma básica, podemos adicionar um log manualmente através do método `activity()` e recuperar suas informações através do método estático `all()`, como no exemplo:

```php
activity()->log("Mensagem do log");

$ultimoLog = Activity::all()->last(); // retorna o último log registrado.
$ultimoLog->description; // retorna a mensagem: "Mensagem do log"
```

### Setando seus atributos

Logs possuem alguns atributos interessantes que podemos utilizar para especificar a ocasião de uma atividade que ocorreu no sistema.

#### Nome, Descrição e Data de Criação

Como mostrado no primeiro exemplo, é possível definir o atributo de descrição para um log. Este é muito importante dentre os atributos básicos, pois clarifica a ação representada pelo log. Também temos a data de criação, que diz quando a ação foi registrada como log, é um atributo automático, porém pode ser especificado para conter alterações. Por último, o atributo nome que serve principalmente para identificar um grupo de logs que pertencem a mesma categoria arbitrária (por padrão recebe o valor presente no arquivo de configuração).

```php
activity()
    ->name("botao")
    ->createdAt(now()->addDay(10)) // Define a criação do log para este instante (2026-01-01 00:00:00) + 10 dias
    ->log("O usuário clicou em um botão."); // Define a descrição do log.

$log = Activity::all()->last();

$log->log_name; // retorna "botao"
$log->description; // retorna a String: "O usuário clicou em um botão."
$log->createdAt // retorna o DateTime "2026-01-11 00:00:00"
```

#### Subject (objeto observado) e Causer (objeto acionador)

É possível setar o objeto "observado" no log e seu objeto "acionador", isto é, o objeto que está sendo referenciado pelo log e o objeto que causou o registro do log (realizou alguma ação sobre o objeto observado). Exemplo:

```php
$causer = usuario;
$subject = produtoAlterado;

activity()
   ->performedOn($subject)
   ->causedBy($causer)
   ->log('Produto foi editado.');

$ultimoLog = Activity::all()->last();

$ultimoLog->subject; // retorna o produto que foi alterado.
$ultimoLog->causer; // retorna o usuário que alterou o produto.
$ultimoLog->description; // retorna a mensagem: "Produto foi editado."
```

#### Customizados: Propriedades, Evento e Tap

O pacote também disponibiliza atributos que podem ser customizados da forma que o usuário desejar.

- **Propriedades:** dados quaisquer que o usuário ache relevantes para aquele log específico e que podem mudar frequentemente. São armazenadas como um array associativo.
- **Eventos:** são flags, podendo ser vistos como uma forma de classificar logs semelhantes de acordo com o tipo de ação realizada. São armazenados como uma string.
- **Tap:** a maneira de alterar dados mais internos do log antes de ele ser efetivado e salvo. Aqui podemos dar valores para as propriedades criadas e, mais importante, criar atributos totalmente novos para um log específico. É único pois o pacote o armazena como uma função, ou seja, pode-se executar qualquer comando antes de criar o dito log.

```php
activity()
    ->log("O usuário fez uma pesquisa.")
    ->withProperties(["pesquisa"=>"Por que gatos são fofos?"])
    ->event("search")
    ->tap(function(Activity $activity) {
        $activity->results = [
            "Porque sim!", 
            "Os felinos na verdade...", 
            "Por que não seriam?"
        ]; // Define os resultados da pesquisa realizada.
    });

$log = Activity::all()->last();

$log->event; // retorna a String "search"
$log->getProperty('pesquisa'); // retorna a String ""
$log->results[0]; // retorna a String "Porque sim!"

```

### Acesso

São disponibilizados alguns métodos estáticos da classe `Spatie\Activitylog\Models\Activity` para obter logs já registrados pela aplicação. Os mais notáveis são `all()`, `where()` e `last()`, que retornam, respectivamente, todos os logs, apenas os logs que correspondem a uma condição e o log mais recente.

```php
$todos = Activity::all(); // retorna todos os logs já registrados.
$filtrados = Activity::where('properties->key', 'value'); retorna todos os logs que tem a 'key' com certo valor.
$ultimo = Activity::all()->last(); // retorna o ultimo log a ser registrado.
```

### Limpeza

Assim como podemos acessá-los, é possível limpar os logs que já existem. Isso é feito pelo prompt utilizando o comando `php artisan activitylog:clean`, que deleta todos os logs mais antigos que o valor presente na variável `clean_after_days` do arquivo de configuração.

Existem também dois parâmetros relevantes:

- `--force`: pula a confirmação de deleção.
- `--days`: ignora a variável `clean_after_days` e utiliza o valor fornecido como parâmetro. 

Exemplos:

```
php artisan activitylog:clean --force // Força a deleção dos logs mais velhos que 365 dias.
php artisan activitylog:clean --days=8 // Solicita a deleção dos logs mais velhos que 8 dias.
```

## Uso Avançado

O que foi visto anteriormente é suficiente para utilizar este pacote, porém há maneiras mais otimizadas de fazê-lo. No uso avançado decidimos abordar a superfície da criação automática de logs e como desabilitar o registro de logs em situações específicas.

### Logging Model Events

A partir desse recurso, é possivel definir que quando determinado model sofrer uma ação (criação, remoção, edição, etc.) um log será registrado automaticamente.

#### LogsActivity Trait

Quando a trait `Spatie\Activitylog\Models\Concerns\LogsActivity` é **usada** em algum model, por padrão, sempre que uma instancia desse modelo for criada, removida ou editada, será registrado um log com o nome do evento: "created", "deleted", "updated" respectivamente.

```php
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class User extends Model {
    use LogsActivity; // Usa o trait.
}
```

Apesar disso, somente essas ações estarão sendo rastreadas. Caso deseje que atributos especificos sejam observados pelo Spatie, usa-se o método `getActivitylogOptions()` que permite configurar intimamente quais e como esses atributos serão registrados.

```php
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class User extends Model {
    use LogsActivity;

    protected $fillable = ['name', 'money'];

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['name', 'text']); 
        // Faz com que sempre que estes atributos sejam alterados, um log é gerado.
        // Se "['*']" for colocado, todos os atributos são rastreados.
    }
}
```

### Desabilitando Logs

Por mais estranho que pareça, é de grande utilidade determinar quando um log pode ou não ser registrado. Podemos desabilitar os logs de certos eventos presentes na trait `LogsActivity` a partir dos atributos estáticos `recordsEvents` e `doNotRecordEvents`

```php
// Guarda somente deleted, esquece created e updated.
protected static $recordEvents = ['deleted'];
```

```php
// Não guarda o evento deleted, mas ainda faz o log de created e updated.
protected static $doNotRecordEvents = ['deleted'];
```

Ou ainda, desabilitar totalmente os logs por determinada parte do código atraves do método `disableLogging()` e `enableLogging()`, especialmente util quando não queremos que o Spatie log centenas de dados de testes em seeders por exemplo.

```php
activity()->disableLogging();

// O usuário é criado sem nenhum log ser salvo.
$user->save();

activity()->enableLogging();
```