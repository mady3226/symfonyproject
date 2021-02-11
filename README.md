# symfonyproject

Test technique « Pricing »

Contexte

Un vendeur vend 1500 jeux vidéo neufs et d'occasion sur la marketplace Amazon.fr. Il a des centaines de concurrents différents qui offrent les même produits, en état neuf ou d'occasion. Certains produits de ses concurrents sont en moins bon état que les siens, d'autres en meilleur état que les siens. Il n’existe que 5 états de produits possibles : « Etat moyen », « Bon état », « Très bon état », « Comme neuf » et « Neuf ». Il définit un prix plancher pour chacun de ses articles. Il veut être moins cher que la concurrence mais ne pas brader ses produits, en ne descendant pas en dessous de son prix plancher.

Question

Comment modéliser la stratégie de prix du vendeur pour qu'il soit toujours 1 centime moins cher que les concurrents qui ont un état égal au sien ou 1 euro moins cher que les concurrents qui ont un meilleur état que le sien, dans la limite du prix plancher ?

Prix de vente Vendeur concurrent Etat de produit

14,10 € Abc jeux Etat moyen

16,20 € Games-planete Etat moyen

18 € Media-games Bon état

20 € Micro-jeux Très bon état

21,50 € Top-Jeux-video Très bon état

24,44 € Tous-les-jeux Bon état

29 € Diffusion-133 Comme neuf

30,99 € France-video Neuf

Dans l’exemple ci-dessus, si le vendeur dispose d'un exemplaire en « Très bon état » avec un prix plancher à 15€, le programme devrait positionner l'article au prix de 19,99€.

Le but est de créer un programme en PHP/Symphony qui : • place le produit face à la concurrence en fonction : ◦ de l'état produit/prix plancher saisi via un formulaire ◦ de la stratégie du prix • affiche les vendeurs sous forme de liste, de la meilleure offre à la moins bonne, selon l’état du produit.
