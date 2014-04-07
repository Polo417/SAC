--------------------------------------------------------------------------------
  TP WEB

  Partie 1 :
  Configuration d'un serveur Web : Apache

  Partie 2 :
  Développement d'un framework Web, page dynamique côté serveur : POKEMON en PHP

  Partie 3 : 
  Ajout aux framework des pages dynamique côté client : Javascript

--------------------------------------------------------------------------------
  J. Ponge, F. Le Mouël - INSA Lyon, Département TC - 2010
--------------------------------------------------------------------------------

Structure du squelette :
.
|-- bin				: utilitaires
|-- doc				: sujets du TP
|-- etc				: répertoire avec fichiers de configuration
|   `-- apache2
|       |-- modules.d
|       `-- vhosts.d
|-- src				: répertoire avec source du framework
|   `-- framework-3TC-WEB
`-- var				
    |-- log			: répertoires de traces
    |   `-- apache2
    |-- run
    `-- www			: répertoire avec données à publier
        `-- localhost
            `-- htdocs

