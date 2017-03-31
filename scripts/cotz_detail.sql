CREATE TABLE `new_ts_4`.`cotz_detail` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_header` INT NULL,
  `codigo_articulo` VARCHAR(45) NULL,
  `nombre_articulo` VARCHAR(45) NULL,
  `descripcion` VARCHAR(255) NULL,
  `cantidad` VARCHAR(45) NULL,
  `unidad_medida` VARCHAR(45) NULL,
  `precio` VARCHAR(45) NULL,
  `descuento_porcentaje` VARCHAR(45) NULL,
  `monto` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));
