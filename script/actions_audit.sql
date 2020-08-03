CREATE TABLE `xtamdb`.`actions_audit` (
  `id` BIGINT(20) NOT NULL,
  `user_id` BIGINT(20) NOT NULL,
  `action_id` INT NOT NULL,
  `action_start_date` DATETIME NULL DEFAULT NOW(),
  `action_end_date` DATETIME NULL DEFAULT NOW(),
  `state` VARCHAR(12) NOT NULL,
  `details` VARCHAR(50) NULL,
  `camera_id` BIGINT(20) NOT NULL,
  `module` VARCHAR(20) NOT NULL,
  `ipserver` VARCHAR(20) NOT NULL,
  `name_channel` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`))
COMMENT = 'Tabla que almacena la auditoria de acciones de usuario con las camaras.';
