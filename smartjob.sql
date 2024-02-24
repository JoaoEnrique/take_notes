-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 26/09/2023 às 07:47
-- Versão do servidor: 10.3.39-MariaDB-cll-lve
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `qgvcdeki_takenotes`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admins`
--

CREATE TABLE `admins` (
  `id_admin` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `admins`
--

INSERT INTO `admins` (`id_admin`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-09-08 18:11:59', '2023-09-08 18:11:59');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contacts`
--

CREATE TABLE `contacts` (
  `id_contact` int(255) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contacts`
--

INSERT INTO `contacts` (`id_contact`, `name`, `phone`, `email`, `message`, `created_at`, `updated_at`) VALUES
(4, 'João', '1198762267', 'joao@gmail.com', 'Olá', '2023-09-15 07:31:05', '2023-09-15 07:31:05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `files_messages`
--

CREATE TABLE `files_messages` (
  `id_files_messages` bigint(20) UNSIGNED NOT NULL,
  `id_message_team` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `type_file` varchar(2) NOT NULL,
  `path_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `files_messages`
--

INSERT INTO `files_messages` (`id_files_messages`, `id_message_team`, `file_name`, `type_file`, `path_file`) VALUES
(19, 58, NULL, '1', 'img/file_messages/58.png'),
(20, 61, 'Apresentação de  Plano de Projeto_First Job2023.pdf', '3', 'img/file_messages/61.pdf'),
(21, 64, NULL, '1', 'img/file_messages/64.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `messages_team`
--

CREATE TABLE `messages_team` (
  `id_message_team` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_team` bigint(20) UNSIGNED NOT NULL,
  `text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `messages_team`
--

INSERT INTO `messages_team` (`id_message_team`, `id_user`, `id_team`, `text`, `created_at`, `updated_at`) VALUES
(58, 1, 6, '\"Boas-vindas a todos! 💛💙\r\nHoje é o começo de algo especial. \r\n\r\nMal posso esperar para ver o progresso que alcançaremos juntos.\"\r\n\r\nÉ importante ressaltar que esse projeto é um trabalho totalmente voluntário, massss como nada na vida é TOTALMENTE de graça, uma coisa será exigida aqui👇🏼\r\nCOMPROMETIMENTO 💫\r\n\r\nHoje iniciamos com 14 participantes no grupo, mas somente os comprometidos com seu futuro vão abraçar essa oportunidade e brilhar no mercado de trabalho. Saibam: É por esses que estou aqui😍\r\n\r\nVou deixar o grupo aberto, para que todos possam se apresentar: 👇🏼😉', '2023-09-17 04:42:27', '2023-09-17 04:56:48'),
(60, 1, 6, 'Ei, jovem!! \r\n\r\nSe você deseja estar preparado para alcançar o primeiro emprego, busca conhecer sobre os segredos e mistérios da realidade do mercado de trabalho…Então esse grupo é para você 👇🏼\r\n\r\nhttps://chat.whatsapp.com/JMb4zRHPJ0x7vqrSp1HECR\r\n\r\nMe permite fazer parte da sua jornada?😍 Vem comigo!!', '2023-09-17 04:58:51', '2023-09-17 05:03:05'),
(61, 1, 6, NULL, '2023-09-17 05:06:30', '2023-09-17 05:06:30'),
(62, 2, 6, 'Olá, sou o João Enrique', '2023-09-17 05:07:13', '2023-09-17 05:07:13'),
(63, 1, 6, 'Boa tarde comprometidos!!\r\n\r\nPra te inspirar!! 🥰\r\n\r\nhttps://www.ted.com/talks/geovana_donella_o_trabalho_nao_e_sem_querer_e_de_proposito', '2023-09-17 05:07:43', '2023-09-17 05:07:43'),
(64, 1, 6, 'Bom diaaaa, comprometidos!\r\n\r\n🎯 Você já parou para pensar que o tempo é o recurso mais importante que temos? Cada minuto, cada hora, é uma oportunidade única para investir em você mesmo, ampliar seus conhecimentos e alcançar seus objetivos.\r\n\r\n⏰ A gestão de tempo é o caminho para o sucesso. Organizar seu dia de forma eficaz não apenas aumenta sua produtividade, mas também libera momentos preciosos para investir em aprendizado e crescimento pessoal.\r\n\r\n📘 Reserve um espaço sagrado em sua agenda para o estudo e o desenvolvimento.\r\n\r\n🚀 Transforme seu tempo em investimento pessoal! 📚Aproveitem as dicas que separei para vocês 👇🏼', '2023-09-17 05:08:42', '2023-09-17 05:08:42'),
(65, 1, 6, 'Esse são os sites para você copiar e salvar:\r\n\r\n1-Sebrae - https://lnkd.in/dxe8bzmp\r\n2-FGV - https://lnkd.in/dXAU_88W\r\n3-Fundação Bradesco - https://lnkd.in/dZUy85a5\r\n4-Udacity - https://www.udacity.com/\r\n5-Coursera - https://www.coursera.org/\r\n6- Grupo Voitto- https://lnkd.in/dJUN4eht\r\n7-Google Ateliê Digital - https://lnkd.in/dRD3wMRH\r\n8-Fecap - https://lnkd.in/d8si9MwC\r\n9-Omie - https://lnkd.in/dB5c2yzR\r\n10-Unicamp - https://lnkd.in/deaEc3q7\r\n11-Unasus - https://lnkd.in/dRz96ZJK\r\n12-Harvard University - https://pll.harvard.edu/\r\n13-Instituto Federal de Rondônia - https://mooc.ifro.edu.br/\r\n14-Institudo Federal do Rio Grande do Sul - https://lnkd.in/dKfhFwUj\r\n15-Eleve - https://lnkd.in/dvKcM4NF', '2023-09-17 05:08:56', '2023-09-17 05:08:56'),
(78, 2, 6, 'Gdgcygdgd', '2023-09-25 00:50:23', '2023-09-25 00:50:23');

-- --------------------------------------------------------

--
-- Estrutura para tabela `students`
--

CREATE TABLE `students` (
  `id_student` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `students`
--

INSERT INTO `students` (`id_student`, `id_user`, `created_at`, `updated_at`) VALUES
(14, 2, '2023-09-12 03:06:32', '2023-09-12 03:06:32');

-- --------------------------------------------------------

--
-- Estrutura para tabela `teams`
--

CREATE TABLE `teams` (
  `id_teams` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` varchar(100) NOT NULL,
  `team_code` varchar(10) NOT NULL,
  `color` varchar(20) NOT NULL,
  `closed` char(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `teams`
--

INSERT INTO `teams` (`id_teams`, `id_user`, `name`, `description`, `team_code`, `color`, `closed`, `created_at`, `updated_at`) VALUES
(6, 1, '2023', 'Turma de 2023', '4QWCB6', 'rgb(25, 103, 210)', NULL, '2023-09-12 03:30:46', '2023-09-17 04:32:38');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `img_account` varchar(255) NOT NULL,
  `active` char(1) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `email_verified_at`, `password`, `img_account`, `active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Take Notes', 'takenotes@gmail.com', 'smart_job', NULL, '$2y$10$Q2kGEHPyvlvWhkLJShZsieLcsElzFoLLQmXiDd202kHq/enxe47X2', 'img/img_account/1.png', '1', NULL, '2023-09-08 18:11:59', '2023-09-11 15:45:36'),
(2, 'João', 'joao@gmail.com', 'joao', NULL, '$2y$10$Zab9Lz642uCpCzvkwMZ0PeIJwfW9doMo2zqLWiGJZBFSIzPbeYZFG', 'img/img_account/2.png', '1', NULL, '2023-09-08 18:11:59', '2023-09-08 18:11:59'),
(3, 'Teste', 'jebsantosalves@gmail.com', 'jebsantosalves@gmail.com', NULL, '$2y$10$De9Wg4z/up8TY.akZle8zOx1tkY7fGk57wMEqORl8HmZWq9g2dWiq', 'img/img_account/img_account.png', '1', NULL, '2023-09-11 14:53:16', '2023-09-11 14:53:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users_teams`
--

CREATE TABLE `users_teams` (
  `id_user_team` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_team` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users_teams`
--

INSERT INTO `users_teams` (`id_user_team`, `id_user`, `id_team`, `created_at`, `updated_at`) VALUES
(1, 2, 6, '2023-09-12 03:32:56', '2023-09-12 03:32:56');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `admins_id_user_foreign` (`id_user`);

--
-- Índices de tabela `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id_contact`);

--
-- Índices de tabela `files_messages`
--
ALTER TABLE `files_messages`
  ADD PRIMARY KEY (`id_files_messages`),
  ADD KEY `files_messages_id_message_team_foreign` (`id_message_team`);

--
-- Índices de tabela `messages_team`
--
ALTER TABLE `messages_team`
  ADD PRIMARY KEY (`id_message_team`),
  ADD KEY `messages_team_id_user_foreign` (`id_user`),
  ADD KEY `messages_team_id_team_foreign` (`id_team`);

--
-- Índices de tabela `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id_student`),
  ADD KEY `students_id_user_foreign` (`id_user`);

--
-- Índices de tabela `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id_teams`),
  ADD KEY `teams_id_user_foreign` (`id_user`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Índices de tabela `users_teams`
--
ALTER TABLE `users_teams`
  ADD PRIMARY KEY (`id_user_team`),
  ADD KEY `users_teams_id_user_foreign` (`id_user`),
  ADD KEY `users_teams_id_team_foreign` (`id_team`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id_contact` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `files_messages`
--
ALTER TABLE `files_messages`
  MODIFY `id_files_messages` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `messages_team`
--
ALTER TABLE `messages_team`
  MODIFY `id_message_team` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de tabela `students`
--
ALTER TABLE `students`
  MODIFY `id_student` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `teams`
--
ALTER TABLE `teams`
  MODIFY `id_teams` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users_teams`
--
ALTER TABLE `users_teams`
  MODIFY `id_user_team` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `files_messages`
--
ALTER TABLE `files_messages`
  ADD CONSTRAINT `files_messages_id_message_team_foreign` FOREIGN KEY (`id_message_team`) REFERENCES `messages_team` (`id_message_team`);

--
-- Restrições para tabelas `messages_team`
--
ALTER TABLE `messages_team`
  ADD CONSTRAINT `messages_team_id_team_foreign` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id_teams`),
  ADD CONSTRAINT `messages_team_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `users_teams`
--
ALTER TABLE `users_teams`
  ADD CONSTRAINT `users_teams_id_team_foreign` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id_teams`),
  ADD CONSTRAINT `users_teams_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
