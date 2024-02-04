# covoiturage

projet tp advenced web
EQUIPE : OULD SLIMANE NEILA HIOUANI LYDIA
Technologie utiliser : php, mysql, javacript, html, css
BDD : phpmyadmin
Pour faire fonctionner le projet :

1. Créer une base de donner nommer « covoiturage »

2. Executer les requete sql suivante pour créer les tables :

CREATE TABLE `administrateur` (
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL,
  `mat_etd` varchar(100) NOT NULL,
  `mdp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`nom`, `prenom`, `email`, `mat_etd`, `mdp`) VALUES
('Hiouani', 'Lydia', 'Lydiahiouani@gmail.com', 'admin202031060760', '16776b6eecfeab41573d9d52e4a2ff89');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(10) UNSIGNED NOT NULL,
  `user` varchar(100) NOT NULL,
  `conducteur` varchar(100) NOT NULL,
  `trajet` int(100) NOT NULL,
  `depart` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `nom_cond` varchar(50) NOT NULL,
  `nom_voyageur` varchar(50) NOT NULL,
  `date_dep` date NOT NULL,
  `heure_dep` time(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `user`, `conducteur`, `trajet`, `depart`, `destination`, `nom_cond`, `nom_voyageur`, `date_dep`, `heure_dep`) VALUES
(4, '191935640176', '35602483475', 1, 'Hammouche, Rue Belouizdad Mohamed, Cité Djezzaz Ali (HBM), Belouizdad, Daïra Hussein Dey, Alger, 160', 'USTHB', 'Hiouani Adnane', 'Filali Sarah', '2024-02-05', '07:30:00.000000');

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

CREATE TABLE `trajet` (
  `id_trajet` int(11) UNSIGNED NOT NULL,
  `depart` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `date_dep` date NOT NULL,
  `heure_dep` time(6) NOT NULL,
  `nb_passager` int(11) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `conducteur` varchar(100) NOT NULL,
  `place_dispo` int(10) NOT NULL,
  `max_passagers` int(11) DEFAULT 4,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `trajet`
--

INSERT INTO `trajet` (`id_trajet`, `depart`, `destination`, `date_dep`, `heure_dep`, `nb_passager`, `latitude`, `longitude`, `conducteur`, `place_dispo`, `max_passagers`, `prix`) VALUES
(1, 'Hammouche, Rue Belouizdad Mohamed, Cité Djezzaz Ali (HBM), Belouizdad, Daïra Hussein Dey, Alger, 160', 'USTHB', '2024-02-05', '07:30:00.000000', 5, 36.749312, 3.0670848, '35602483475', 4, 4, 500),
(2, 'Hammouche, Rue Belouizdad Mohamed, Cité Djezzaz Ali (HBM), Belouizdad, Daïra Hussein Dey, Alger, 160', 'Grande poste', '2024-02-04', '06:15:00.000000', 3, 36.749312, 3.0670848, '35602483475', 3, 4, 350),
(8, 'Cité Zerhouni Mokhtar (Les Bananiers), Lotissement les Mandariniers, Tamaris, Mohammadia, Daïra Dar ', 'Amirouche', '2023-12-08', '15:20:00.000000', 2, 36.7296512, 3.1719424, '35602483475', 2, 4, 600),
(9, 'Cité Zerhouni Mokhtar (Les Bananiers), Lotissement les Mandariniers, Tamaris, Mohammadia, Daïra Dar ', 'Hydra', '2024-01-17', '14:05:00.000000', 3, 36.7296512, 3.1719424, '35602483475', 3, 4, 200);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `num_tel` int(12) NOT NULL,
  `email` varchar(30) NOT NULL,
  `mat_etd` varchar(100) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `created_at` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`nom`, `prenom`, `num_tel`, `email`, `mat_etd`, `mdp`, `latitude`, `longitude`, `created_at`) VALUES
('Nouioua', 'Amira', 524789435, 'namira@gmail.com', '161650248367', '974491f709d4ed36d9b502a6d72a3cd2', 36.749312, 3.0670848, '2023-12-28'),
('Filali', 'Sarah', 763419945, 'fsarah@gmail.com', '191935640176', '94675e9d9d7f97758c09a7d50e8d2471', 36.7296512, 3.1719424, '2024-02-04');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `num_tel` int(12) NOT NULL,
  `email` varchar(30) NOT NULL,
  `mat_etd` varchar(100) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `matricule_v` varchar(25) DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`nom`, `prenom`, `num_tel`, `email`, `mat_etd`, `mdp`, `matricule_v`, `created_at`) VALUES
('Hiouani', 'Nawel', 560512195, 'hammitoche@hotmail.fr', '2020310DZ60', '7990bf6bec646ab25b8117f001688733', '291297-114-16', '2024-02-01'),
('Ould Slimane', 'Neila', 642762840, 'neilaos@gmail.com', '2020CON60432', 'd7425318e795279c766631c2a7034897', '645203-117-16', '2024-01-02'),
('Hiouani', 'Adnane', 560106635, 'Addykanane@gmail.com', '35602483475', 'e3da99db4435eacf237437accd4c10ee', '055907-116-16 ', '2024-02-04');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`mat_etd`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`);

--
-- Index pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD PRIMARY KEY (`id_trajet`),
  ADD KEY `conducteur` (`conducteur`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`mat_etd`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`mat_etd`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
  MODIFY `id_trajet` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD CONSTRAINT `trajet_ibfk_1` FOREIGN KEY (`conducteur`) REFERENCES `utilisateur` (`mat_etd`);
COMMIT;
