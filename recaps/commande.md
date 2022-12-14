Your entity already exists! So let's add some new fields!

 New property name (press <return> to stop adding fields):
 > โกโขโขโข๐บ๐ผ๐๐ถ๐ฒโก

 Field type (enter ? to see all types) [string]:
 > โกโขโขโข๐ฟ๐ฒ๐น๐ฎ๐๐ถ๐ผ๐ปโก

 What class should this entity be related to?:
 > โกโขโขโข๐บ๐ผ๐๐ถ๐ฒโก

What type of relationship is this?
 --------------------------------------------------------------------
  Type Description                                                        
------------------------------------------------------------------- 
  ManyToOne    Each Season relates to (has) one movie.                            
               Each movie can relate to (can have) many Season objects            
                                                                                  
  OneToMany    Each Season can relate to (can have) many movie objects.           
               Each movie relates to (has) one Season                             
                                                                                  
  ManyToMany   Each Season can relate to (can have) many movie objects.           
               Each movie can also relate to (can also have) many Season objects  
                                                                                  
  OneToOne     Each Season relates to (has) exactly one movie.                    
               Each movie also relates to (has) exactly one Season.               
 --------------------------------------------------------------------


 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > โกโขโขโข๐ ๐ฎ๐ป๐๐ง๐ผ๐ข๐ป๐ฒโก

 Is the Season.movie property allowed to be null (nullable)? (yes/no) [yes]:
 > โกโขโขโข๐ป๐ผโก

 Do you want to add a new property to movie so that you can access/update Season objects from it - e.g. $movie->getSeasons()? (yes/no) [yes]:
 > โกโขโขโข๐๐ฒ๐โก

 A new property will also be added to the movie class so that you can access the related Season objects from it.

 New field name inside movie [seasons]:
 > โกโขโขโข๐๐ฒ๐ฎ๐๐ผ๐ป๐โก

 Do you want to activate orphanRemoval on your relationship?
 A Season is "orphaned" when it is removed from its related movie.
 e.g. $movie->removeSeason($season)
 
 NOTE: If a Season may *change* from one movie to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\Season objects (orphanRemoval)? (yes/no) [no]:
 > โกโขโขโข๐๐ฒ๐โก

 updated: src/Entity/Season.php
 updated: src/Entity/Movie.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 ---------------------------
 > โกโฃโฃโข๐ฆ๐๐ฐ๐ฐ๐ฒ๐๐โก
-----------------------------
Next: When you're ready, create a migration with php bin/console make:migration



- php bin/console ma:mi = make:migration
- php bin/console d:m:m = doctrine:make:migrate




Je veux crรฉer une relation entre deux entitรฉs suivant mon MCD.

Je vais donc dรฉtailler ร  Doctrine ce que je veux.

Pour les relations, la seule chose qui nous intรฉresse dans le MCD, c'est la cardinalitรฉ MAX, le 0 ou 1 de la cardinalitรฉ MIN est lร  pour l'option de nullitรฉ.

Je pars de mon MCD et je note :

- N de mon cotรฉ, et 1 de l'autre
- ManyToOne
- 1 de mon cotรฉ, et N de l'autre
- OneToMany
- N de mon cotรฉ, et N de l'autre
- ManyToMany

Ce qui est important pour Doctrine c'est qui porte la relation : mappedBy OU inversedBy

## ManyToOne

Je suis le porteur de la relation, c'est moi qui dans la base contient la FK.
Dans le code, je doit avoir :

1
2
3
4
/* dans la classe Post
* @ORM\ManyToOne(targetEntity=Author::class, inversedBy="posts")
*/
 private $author;

J'ai donc une propriรฉtรฉ dans ma classe porteuse avec un objet de la classe correspondante (dans l'exemple Author)
Je doit trouver un inversedBy

## OneToMany

Je NE suis PAS le porteur de la relation, c'est l'autre qui dans la base contient la FK.
Dans le code, je doit avoir :

1
2
3
4
/** dans la classe Author
 * @ORM\OneToMany(targetEntity=Post::class, mappedBy="author")
 */
private $posts;

J'ai donc une propriรฉtรฉ dans ma classe avec un ArrayCollection qui contient toutes les instances des objets liรฉs (dans l'exemple Post)
Je doit trouver un mappedBy

## ManyToMany

Aucune des deux tables ne porte de FK, il y a une table pivot.
Dans le code je doit avoir :

1
2
3
4
/** dans la classe Tag
 * @ORM\ManyToMany(targetEntity=Post::class, mappedBy="tags")
 */
private $posts;

1
2
3
4
/** dans la classe Post
* @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="posts")
*/
private $tags;

Mais ?? pourquoi on a quand mรชme mappedBy OU inversedBy ?

Il faut quand mรชme donner ร  Doctrine qui des deux entitรฉs est l'entitรฉ porteuse, celle qui est la plus logique, ร  vous de dรฉcider suivant le cas.
L'idรฉe est que l'on veux avoir la collection d'entitรฉ depuis l'une plutรดt que depuis l'autre.

Dans notre exemple, un Post est notre objet porteur car on affichera les tags dans la page du post, et pas l'inverse.
Donc on doit avoir inversedBy dans notre classe Post