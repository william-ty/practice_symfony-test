### Reponses Test Technique

Remarques: 
- La base de ce projet a été utilisé à des fins de formation. Les nommages devraient être en anglais.
- Les classes sont renseignées dans ce document pour y accéder plus rapidement.
- L'arborescence n'est peut-être pas optimale elle reprend vaguement la progression par étape au fil des questions.
- Seules les questions pouvant bénéficier d'un exemple sont présentes.


2 - Quelles sont les informations qui caractérisent une route ?

Exemple : 
use App\Controller\MessageController;
Méthode edtiMessage() ligne 27

Une route est caractérisée par :
- Un nom (message_edit)
- Une URL (/message/{id}/edit)
- Un Controller (MessageController)
- Des paramètres ({id})
- Des contraintes (requirements={"id"="\d+"})
- Des valeurs par défauts(exemple: defaults={"page"=1})


4 - Comment récupérer l'utilisateur courant depuis un Controller ? depuis un service ? depuis une vue Twig ?

Controller: `$this->getUser()`; 
VueTWIG: Variable globale 'app': `app.user`

Service: En injectant le composant de sécurité:
`public function index(Security) $security) { $user = $security->getUser();}`
Exemple : 
use App\Service\LoggerService;
/practice_symfony-test/config/services.yaml

(Un service Logger a été créé pour en pratiquer l'exemple)


6 - Qu'est ce que le "service container" ? A quoi sert-il ?

Le service container (ou dependency injection container) est une classe qui s'occupe d'organiser et d'instancier les services.

https://symfony.com/doc/current/service_container.html

Le service container peut être considéré comme le coeur de Symfony.

Il construit des instances d'objets à partir des classes qu'il connait.

Exemple: Passer le ManagerRegistery en paramètre à la méthode d'un contrôleur est automatiquement detecté par le container de service qui reconnait que cet objet est necessité.

Pour afficher les services disponibles :
`php bin/console debug:autowiring --all`

Usuellement, trois sources de services sont mise à l'intérieur du container de services:
- /src
- Les bundles
- services.yml

Remarque: Présent depuis la version 2.0 de Symfony.


7 - Qu'est ce que l'autowiring ? Que permet-il ?

L'autorwiring est une fonctionnalité (depuis Symfony 3.4) permettant d'automatiser l'injection des dépendances. Il transforme toutes les classes du répértoire SRC en service que l'on peut injecter directement dans les Controllers, les autres services... à l'exception des répertoires Entity, Migrations, Tests et la classe Kernel.php. (par defaut)

---

Utilise le type-hinting dans les constructeurs et la config `autowiring: true` dans le `services.yml`.

https://symfonycasts.com/screencast/new-in-symfony3/autowiring
https://symfony.com/doc/current/service_container/autowiring.html

8 - Qu'est ce qu'un tag de service ? à quoi sert-il ?

Un tag de service permet de dire à Symfony qu'un service doit être enregistré d'une manière différente d'un service normal. Par exmple, le tag "twig.extention" permet de dire à Symfony qu'un service est une extension Twig utilisable directement depuis les vues.

Exemple dans la question 17.

https://symfony.com/doc/current/service_container/tags.html
https://symfony.com/doc/current/reference/dic_tags.html


10 - A quoi sert un ParamConverter ?

Un ParamConverter permet de transformer automatiquement un paramètre de route en objet injecté directement dans le Controller.

-> Ainsi un {id} passé dans la définition d'une route par annotation sera passé en objet dans la méthode concernée s'il est passé en argument.

Exemple : 
use App\Controller\SujetController;
Méthode addEditSujet() ligne 31

https://symfony.com/bundles/SensioFrameworkExtraBundle/current/annotations/converters.html
https://www.novaway.fr/blog/tech/comment-creer-ses-propres-paramconverters-avec-symfony


12 - Qu'est ce qu'une méthode magique ?

Une méthode magique est une méthode qui, si elle est présente dans la classe, sera appelée lors de tel ou tel évènement. Par exemple, la méthode magique __construct sera appelée lors de l'instanciation...

-> De même que la méthode __toString() est appelée à lorsque qu'un objet est affiché en chaine de caractères.


15 - En quoi consiste le design pattern "Decorator" ? Illustrez vos propos...

Design pattern Structurel.

Le design pattern "Decorator" permet d'ajouter des fonctionnalités nouvelles à une classe de façon dynamique sans impacter les classes qui l'utilisent ou en héritent.

Il conserve l'interface de l'objet original et l'étend progressivement à l'ajout de décorateurs.
L'ajout d'objets étend les fonctionnalités.

-> Ajouter des fonctionnalités à un objet existant.

Exemple:
use App\Decorator\MessageDecoratorInterface;
use App\Decorator\MessageDecorator;
use App\Decorator\BoldMessageDecorator;
use App\Decorator\AuthorDateMessageDecorator;
use App\Controller\MessageController;
Methode showMessage ligne 29


https://refactoring.guru/design-patterns/decorator


16 - En quoi consiste le design patter "Strategy" ? illustrez vos propos...

Le design pattern "Strategy" est un patron de conception de type comportemental grâce auquel des algorithmes peuvent être sélectionnées à la volée au cours du temps d'exécution selon certaines conditions.

Change facilement de comportement en choissant une "stratégie" différente sans avoir à changer la structure de l'objet.

-> Choisir entre différents comportements ou algorithmes pour un objet existant.

Exemple:
use App\Strategy\MessageFormatterInterface;
use App\Strategy\HtmlFormatter;
use App\Strategy\PlainTextFormatter;
use App\Controller\MessageController;
Constructeur et Methode showMessage ligne 29

https://refactoring.guru/design-patterns/strategy


17 - Qu'est-ce qu'un CompilerPass ?

Un CompilerPass est un objet, une classe qui impplémente le CompilerPassInterface du composant DependancyInjection de Symfony et qui permet d'ajouter une passe de compilation du container de service. Il peut, par exemple, être utilisé pour mettre en place le design pattern "Strategy".

-> Personnaliser les services de Symfony. Entendre ou remplacer, ajouter des comportements supplémentaires aux services existants.

Exemple:
use App\DependencyInjection\MessageFormatterCompilerPass;
use App\Service\MessageFormatterService;
/practice_symfony-test/config/services.yaml
(Cet exemple est très simplifié, avec une seul "stratégie" de formattage, et non utilisé dans un controlleur)

La classe MessageFormatterCompilerPass configure des services de formatage de message en utilisant le pattern Stategy.
Elle s'execute lorsque les services sont compilés (en étendant la classe CompilerPassInterface). 
La méthode "process" trouve les services tagués recherchés puis les ajoute à un service existant qui gère les différentes stratégies de formatage de message.


13 & 18 - Qu'est ce qu'un trait ?
Supposons un site E-commerce en ligne. Ce site gère tout un ensemble d'entité telles que des produits, des articles de blog, des utilisateurs... Le client demande d'ajouter la date d'enregistrement et de dernière modification de chacune de ces entités. Comment procéderiez-vous ? Quel design pattern utiliser ? Quelle classe devrez-vous créer ? (le code de ces classes n'est pas demandé).

13: 
Un trait est une classe que l'on ne peut instnacier et qui définit un ensemble de propriétés et de méthodes réutilisables dans d'autres classes.

https://www.php.net/manual/fr/language.oop5.traits.php
https://weenesta.com/fr/blog/post/utiliser-traits-symfony

18:
Dans un premier temps, il faut créer un EntityTimeTrait contenant les propriétés "createdAd" et "updatedAt" avec leurs getters et setters et l'ajouter dans les entités.

Dans un second temps, on peut utiliser le design pattern "Adapter" et créer un EntityRepositoryAdapter (implémentant une interface EntityRepositoryInterface) contenant les méthodes "save" et "update", méthodes qui utiliseront l'EntityManager de Doctrine (ou plutôt son interface) pour persister/flusher les entités apèrs avoir setter les propriétés "createdAt" et "updatedAt".

Dans un troisième temps, on intégre l'utilisation de cet Adapter dans les Controllers.

TODO - Demander vérification utilisation Adapter

use App\Entity\User;
use App\Entity\Traits\EntityTimeTrait;
use App\Adapter\EntityRepositoryInterface;
use App\Adapter\EntityRepositoryAdapter;
use App\Controller\RegistrationController;


https://refactoring.guru/design-patterns/adapter

L'Adapter permet d'adapter l'interface d'un objet existant à une interface attendue pour en permettre l'interaction autrement incompatible. 
_________________________________________

Notes: 

https://blog.eleven-labs.com/en/dependency-injection/
https://symfony.com/doc/current/components/dependency_injection/workflow.html

Questions:

18: Y a t'il des cas où les traits entravent l'utilisation de doctrine pour les migrations et la mise à jour des schémas ?
14: 14 est repris dans la question 18 ? Termes et vocab à discuter.
