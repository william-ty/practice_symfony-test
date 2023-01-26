<?php

// ! REFERENCE REPONSE TEST TECHNIQUE - 17 (& 16):

namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class MessageFormatterCompilerPass implements CompilerPassInterface
{

  public function process(ContainerBuilder $container)
  {

    // Obtient les IDs des services tagués "message_formatter"
    $taggedServices = $container->findTaggedServiceIds('message_formatter');

    // Obtient la définition du service "message.formatter"
    $messageFormatterDefinition = $container->getDefinition('message.formatter');

    // Ajoute les services tagués obtenus à la définition obtenue
    foreach ($taggedServices as $id => $tags) {
      $messageFormatterDefinition->addMethodCall(
        'addFormatter',
        [$container->getDefinition($id)]
      );
    }

  }

}

// Notes: 
// process() {}
// findTaggedServiceIds()
// getDefinition()  
// setClass()
// setArgument()