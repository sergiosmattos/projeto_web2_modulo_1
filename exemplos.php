<?php

    // Data e Descrição

    activity()
        ->createdAt(now()) // Define o momento atual como data de criação do log. 
        ->log("O usuário clicou em um botão."); // Define a descrição do log.

    $log = Activity::all()->last();
    $log->description; // Retorna a String: "O usuário clicou em um botão."
    $log->

    //Customizados

    activity1()
        ->log("O usuário fez uma pesquisa.")
        ->withProperties(["pesquisa"=>"Por que gatos são fofos?"])
        ->event("searched")
        ->tap(function(Activity $activity) {
            $activity->results = ["Porque sim!", "Os felinos na verdade...", "Por que não seriam?"]; // Define a variavel resultCount (quantidade de correspondencias a pesquisa)
        });

    $log1 = Activity::all()->last();
    
    $log1->getProperty('pesquisa'); // Retorna a String ""
    $log1->results[0]; // Retorna a String "Porque sim!"

?>