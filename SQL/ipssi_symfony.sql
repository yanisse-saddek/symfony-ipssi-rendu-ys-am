-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 03 déc. 2022 à 23:42
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ipssi_symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `created_at`, `updated_at`, `published`) VALUES
(1, 'Ouverture du nouveau site de e commerce dédié au gameurs', 'Salut a tous les gameurs passez vos commande de suite !!', '2022-12-03 22:57:13', '2022-12-03 23:04:41', 1),
(2, 'Le second article du site', 'Bienvenu au nouveaux inscrit', '2022-12-03 22:57:25', '2022-12-03 23:04:48', 1),
(3, 'Voici le troisième article du site', 'Le site est encore au top du top !', '2022-12-03 22:58:36', '2022-12-03 23:04:52', 0),
(4, 'Hello les gameurs !', 'Bonjour les gameurs ! Comment allez vous ! Voici le 4ème article 😎😎😎', '2022-12-03 23:30:39', '2022-12-03 23:30:39', 1);

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `user_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `cart_product`
--

CREATE TABLE `cart_product` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `cart_product_id` int(11) DEFAULT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `created_at`) VALUES
(1, 'Tablette', '2022-12-03 22:54:21'),
(2, 'Ecran', '2022-12-03 22:54:28'),
(3, 'Ordinateur', '2022-12-03 23:02:44'),
(4, 'Ordinateur Portable', '2022-12-03 23:02:52'),
(5, 'Téléphone', '2022-12-03 23:02:57'),
(6, 'Télé', '2022-12-03 23:03:03');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `seller_id`, `category_id`, `title`, `description`, `price`, `created_at`, `updated_at`, `brand`, `image`, `quantity`, `published`) VALUES
(1, 2, 4, 'Ordinateur portable  Thomson', 'Un très bon processeur rapport qualité prix avec une bonne carte graphique.', 200, '2022-12-03 23:07:37', '2022-12-03 23:07:37', 'Thomson', 'https://img.leboncoin.fr/api/v1/lbcpb1/images/60/24/e3/6024e3da7742e0f40a1a66bd26dd6a0812cd3697.jpg?rule=classified-1200x800-webp', 30, 1),
(2, 2, 6, 'Télévision DELL', 'Un bon modèle pour une télévision de salon', 250, '2022-12-03 23:08:45', '2022-12-03 23:08:45', 'Dell', 'https://img.leboncoin.fr/api/v1/lbcpb1/images/23/be/60/23be60ef1ef0f9329e7629a536e91629e59c4d81.jpg?rule=classified-1200x800-webp', 50, 1),
(3, 4, 5, 'iPhone 11', 'Bonjour tout le monde, je vends mes 4 iphone 11 car je ne m\'en sert pas voila voila. attention ca part vite !!!', 400, '2022-12-03 23:33:50', '2022-12-03 23:33:50', 'Apple', 'https://img.leboncoin.fr/api/v1/lbcpb1/images/94/77/51/947751c4a9e04a2ed8cfa87ef9df6852155ee520.jpg?rule=classified-1200x800-webp', 4, 1),
(4, 4, 1, 'Tablette Huawei', 'Voila, bonjour, je vends des tablettes Huawei avec un très bon macro processeur intel quadcore 719.', 200, '2022-12-03 23:35:31', '2022-12-03 23:35:31', 'Huawei', 'https://img.leboncoin.fr/api/v1/lbcpb1/images/77/f2/ca/77f2cafed1974a28a9c8d7f5128fb347b647f4e4.jpg?rule=classified-1200x800-webp', 9, 1),
(5, 4, 3, 'PC Fixe', 'Je vends mon ordinateur fixe car je ne m\'en sert plus, il est vraiment au top du top avec sa maxi carte graphique de la marque nvidia geforce 667', 800, '2022-12-03 23:37:13', '2022-12-03 23:37:13', 'Asus', 'https://img.leboncoin.fr/api/v1/lbcpb1/images/6a/f9/e8/6af9e840e63ec39be960c3753d4f029cb228494b.jpg?rule=classified-1200x800-webp', 1, 0),
(6, 4, 2, 'Ecran SONY', 'Ecran sony 4k   1 milliard de couleurs OLED', 700, '2022-12-03 23:38:27', '2022-12-03 23:38:27', 'SONY', 'https://img.leboncoin.fr/api/v1/lbcpb1/images/32/d5/b3/32d5b3a7eb29dfa86cdf77c89eadc53b03246fc3.jpg?rule=classified-1200x800-webp', 8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `cart_id`, `email`, `roles`, `password`, `name`, `firstname`, `created_at`) VALUES
(1, NULL, 'admin@admin.fr', '[\"ROLE_ADMIN\"]', '$2y$13$3S3arwXGEJNnG3kEHJq7zuwH6JIsOPJmJY1VQTsKuLSXC38CcRly.', 'monsieur', 'admin', '2022-12-03 22:52:48'),
(2, NULL, 'vendeur@vendeur.fr', '[\"ROLE_SELLER\"]', '$2y$13$cJuhoNKGR1bIEptlUCjSJO9sf2d6ZtYDA9J3LJaYRs34OTNTpFXtm', 'Jean', 'Dupont', '2022-12-03 23:05:41'),
(3, NULL, 'acheteur@acheteur.fr', '[\"ROLE_USER\"]', '$2y$13$9urlSisJI4UhmAFlOqs02ezjSH/GMd5ue7VVZs9yRqUj94Wj3A.Gi', 'Thomassin', 'Romain', '2022-12-03 23:29:38'),
(4, NULL, 'vendeur@vendeur2.fr', '[\"ROLE_SELLER\"]', '$2y$13$XDlKVJ5UsfWby2hwn7K66.5QddyAuW/xO4rkbDKQHpmZjio2pupp6', 'Jean', 'Kevin', '2022-12-03 23:32:04');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_BA388B7A76ED395` (`user_id`);

--
-- Index pour la table `cart_product`
--
ALTER TABLE `cart_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2890CCAA1AD5CDBF` (`cart_id`),
  ADD KEY `IDX_2890CCAA25EE16A8` (`cart_product_id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD8DE820D9` (`seller_id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_8D93D6491AD5CDBF` (`cart_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `cart_product`
--
ALTER TABLE `cart_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_BA388B7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `cart_product`
--
ALTER TABLE `cart_product`
  ADD CONSTRAINT `FK_2890CCAA1AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `FK_2890CCAA25EE16A8` FOREIGN KEY (`cart_product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D34A04AD8DE820D9` FOREIGN KEY (`seller_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6491AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
