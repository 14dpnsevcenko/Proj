
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pass` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `users` (`id`, `login`, `pass`, `email`, `is_admin`) VALUES
(2, 'Niks Sevcenko', '123', 'shevchaaa5@gmail.com', 0),
(4, 'depressedkid', '123123', 'nen4iks@gmail.com', 0),
(12, 'Lucia Muertos', '123', 'faciedplay2005@gmail.com', 0),
(13, '123', 'admin', 'admin@admin.com', 1),
(14, '123', '123', '123@123', 0);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

