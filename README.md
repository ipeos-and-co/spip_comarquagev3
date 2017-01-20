# Co-Marquage Service Public

## Présentation

*Co-Marquage Service Public* est un *plugin* permettant d'intégrer et
de rediffuser, sur un site fonctionnant sous [SPIP](http://www.spip.net/>),
les contenus et services offerts par le portail de l'administration française,
[Service-public.fr](https://www.service-public.fr/).

Ce *plugin* fonctionne avec le *Flux v3* de co-marquage et peut remplacer de
manière transparente le plugin
[Comarquage Service public Flux v2](https://contrib.spip.net/Comarquage-Service-public-Flux-v2)
sur un site existant.

### À propos du co-marquage

Le co-marquage s'adresse aux services de l'État et aux administrations locales :
il permet aux sites web locaux de rediffuser les contenus et les services
offerts par le portail de l'administration française
[Service-public.fr](https://www.service-public.fr/), en le complétant par des
informations locales : coordonnées d’organismes, téléservices locaux, etc.

Depuis août 2016, une nouvelle organisation des fichiers XML, appelée
*Flux v3* a été mise en place et l'arrêt des mises à jour du *Flux v2* a été
[annoncée officiellement](https://www.service-public.fr/partenaires/comarquage/actualites/15-06-2016-evolution-flux-en-2016).


## Installation

L’installation se déroule comme pour tous les
[autres plugins](http://www.spip.net/fr_article3396.html).

### Compatibilité avec la version 0.x

Si vous utilisez déjà le plugin
[Comarquage Service public Flux v2](https://contrib.spip.net/Comarquage-Service-public-Flux-v2)
aucune modification des squelettes existants n'est à effectuer ; les nouveaux
modèles remplacent ceux fournis par
[Comarquage Service public Flux v2](https://contrib.spip.net/Comarquage-Service-public-Flux-v2).

## Utilisation

Après avoir installé le plugin, le flux s'insère dans un article au moyen des modèles suivants :

- flux pour les *Particuliers* : `<comarquage|categorie=particuliers>`
- flux pour les *Professionnels* : `<comarquage|categorie=entreprises>`
- flux pour les *Associations* : `<comarquage|categorie=associations>`

### Intégration

Les squelettes de *Co-Marquage Service Public* utilisent les classes et composants de
[Twitter Bootstrap v3.3.7](https://getbootstrap.com).

Le flux est récupéré grâce à la balise DATA. Les boucles sont en cache
par défaut pendant **86400 secondes** (soit 24 h).

Les XMLs de co-marquage sont copiés en local `|copie_locale{modif}`. Pour
forcer le re-téléchargement des XMLs vider le répertoire `IMG/distant/xml`.

### Astuces

Vous pouvez appeler une page précise en définissant l'attribut `xml` du modèle.

Par exemple pour afficher la page *Mariage* de la catégorie *particuliers*, utilisez ce code : `<comarquage|categorie=particuliers|xml=N142>`.

Pour appeler la page *Formalités administratives* de la catégorie
*Associations*, insérer ce code :
`<comarquage|categorie=associations|xml=N31403>`.

## TODO

- Gérer les pivots pour les informations locales ;
- ajouter un moteur de recherche interne au co-marquage ;
- prendre en charge les redirections. cf. `redirection.xml` ;
- gérer les définitions et les acronymes. cf `<lienintra>` `<definition>`.

## Contribuer

Ce plugin a été développé par [IPEOS I-Solutions](http://www.ipeos.com) pour
la plate-forme [I-Administration](http://www.i-administration.fr) et ajouté aux
contributions de la [communauté SPIP](https://contrib.spip.net/).

Si vous trouvez ce plugin utile, vous pouvez :

- [soumettre un Pull Request](https://github.com/ipeos-and-co/spip_comarquagev3), 
pour que nous intégrions vos améliorations ou corrections de bug ;
- [participer aux forums](http://contrib.spip.net/?article4858) et aider les
utilisateurs à intégrer ce plugin.

### Team
- [Mickaël Hippocrate](https://github.com/mickaelh/)
- [Laurent Vergerolle](https://github.com/psychoz971/)
- [Olivier Watté](https://github.com/owatte/)
