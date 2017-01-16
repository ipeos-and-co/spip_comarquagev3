# Comarquage - Flux v3

## Présentation

Comarquage - Flux v3 est  un *plugin* permettant d'intégrer et rediffuser,
sur un site fonctionnant sous `SPIP <http://www.spip.net/>`_, les contenus et
services offerts par le portail de l'administration française,
`Service-public.fr <https://www.service-public.fr/>`_.

Depuis août 2016, une nouvelle organisation des fichiers XML, appelée
"Flux v3" a été mise en place et l'arrêt des mises à jour du "Flux v2" a été
`annoncé officiellement <https://www.service-public.fr/partenaires/comarquage/actualites/15-06-2016-evolution-flux-en-2016>`_.
C'est pourquoi l'équipe de `IPEOS I-Solutions <http://www.ipeos.net>`_ c'est
attelé à développer une version de comarquage sur le flux recommandé.

Ce *plugin* a été développé pour les besoins de
`IPEOS I-Solutions <http://www.ipeos.net>`_ par `Mickaël Hippocrate` et
`Laurent Vergerolle`.

### À propos du comarquage

Le comarquage s'adresse aux services de l'état et administrations locales, il
permet aux sites web locaux de rediffuser les contenus et les services offerts
par le portail de l'administration française
`Service-public.fr <https://www.service-public.fr/>`_ , en le complétant par des
informations locales : coordonnées d’organismes, téléservices locaux, etc.

## Installation

L’installation se déroule comme pour tous les
`autres plugins <http://www.spip.net/fr_article3396.html>`_.

## Compatibilité avec le plugins Comarquage Service public Flux v2

Si vous utilisé le plugin
`Comarquage Service public Flux v2 <https://contrib.spip.net/Comarquage-Service-public-Flux-v2>`_
vous devez simplement désactiver ce plugin et activer le
*plugin Comarquage - Flux v3*.

L'ensemble des modèles existants dans le plugin
`Comarquage Service public Flux v2 <https://contrib.spip.net/Comarquage-Service-public-Flux-v2>`
ont été conservés pour assurer une continuité de service.

## Utilisation

Installer le plugin.

Le flux s'insère dans un article au moyen des modèles suivants :

`<comarquage|categorie=particuliers>` pour le flux pour les *Particuliers*

`<comarquage|categorie=entreprises>` pour le flux pour les *Professionnels*

`<comarquage|categorie=associations>` pour le flux pour les *Associations*

### Intégration

Les squelettes du comarquage utilisent les classes et composants de
`Twitter Bootstrap v 3.3.7 <https://getbootstrap.com>`_ .

Le flux est récupérer grâce à la balise DATA. Les boucles sont en cache
par défaut pendant **86400 secondes** soit 1 jour.

Les XMLs de comarquage sont copiés en locale `|copie_locale{modif}`. Pour
forcer le re-téléchargement des XMLs vider le répertoire `IMG/distant/xml`.

### Astuces

Vous pouvez préciser une page précise en définissant les attributs xml de l'url.

Par exemple pour appeler la page *Mariage* de la catégorie *particuliers*
utilisez ce code :

`<comarquage|categorie=particuliers|xml=N142>`

Pour appeler la page *Formalités administratives* de la catégorie
*Associations*, insérer ce code :

`<comarquage|categorie=associations|xml=N31403>`

## TODO

- Gérer les pivots pour les informations locales
- Ajouter un moteur de recherche interne au comarquage
- Prendre en charge les redirections. cf. `redirection.xml`
- Gérer les définitions et les acronymes. cf `<lienintra>` `<definition>`
