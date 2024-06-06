INSERT INTO `users` (`id`, `name`, `email`, `password`, `firstName`, `lastName`, `phone`, `country`, `city`, `address`, `zipCode`, `state`, `avatar`, `role`, `remember_token`, `stripe_id`, `pm_type`, `pm_last_four`, `createdAt`)
VALUES
  (1, 'admin', 'admin@eparts.com', '$2y$10$Qja640FrEsiBnQlmYcincOZfCRHri3BTPFpg/If5tEjDQuVnQfIk2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', 'admin', NULL, NULL, NULL, NULL, '2024-05-30 00:00:00'),
  (2, 'manager', 'manager@eparts.com', '$2y$10$Qja640FrEsiBnQlmYcincOZfCRHri3BTPFpg/If5tEjDQuVnQfIk2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', 'manager', NULL, NULL, NULL, NULL, '2024-05-30 00:00:00'),
  (3, 'user', 'user@eparts.com', '$2y$10$Qja640FrEsiBnQlmYcincOZfCRHri3BTPFpg/If5tEjDQuVnQfIk2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.png', 'user', NULL, NULL, NULL, NULL, '2024-05-30 00:00:00');

