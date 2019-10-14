CREATE TABLE `cotz_header` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `vendedor_id` INT NULL,
  `fecha_cotizacion` DATETIME NULL,
  `fecha_vencimiento` DATE NULL,
  `tasa_impuestos` VARCHAR(45) NULL,
  `moneda` VARCHAR(45) NULL,
  `factor_redondeo` VARCHAR(45) NULL,
  `no_solicitud` VARCHAR(45) NULL,
  `no_cotizacion` VARCHAR(45) NULL,
  `account_id` INT NULL,
  `contact_id` INT NULL,
  `tiempo_entrega` VARCHAR(45) NULL,
  `lugar_entrega` VARCHAR(45) NULL,
  `forma_pago` VARCHAR(45) NULL,
  `marca` VARCHAR(45) NULL,
  `fase` VARCHAR(45) NULL,
  `notas` VARCHAR(45) NULL,
  `notas_crm` VARCHAR(45) NULL,
  `fecha_creacion` DATETIME NULL,
  `fecha_modificacion` DATETIME NULL,
  `modificado_por` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));


ALTER TABLE `cotz_header` 
ADD COLUMN `subtotal` VARCHAR(45) NULL AFTER `modificado_por`,
ADD COLUMN `descuento` VARCHAR(45) NULL AFTER `subtotal`,
ADD COLUMN `impuesto` VARCHAR(45) NULL AFTER `descuento`,
ADD COLUMN `total` VARCHAR(45) NULL AFTER `impuesto`;

ALTER TABLE `cotz_header` 
ADD COLUMN `orden_de_compra` VARCHAR(55) NULL AFTER `version`,
ADD COLUMN `oferta_recibida` INT NULL AFTER `orden_de_compra`,
ADD COLUMN `seguimiento` VARCHAR(3000) NULL AFTER `oferta_recibida`,
ADD COLUMN `fecha_entrega` VARCHAR(45) NULL AFTER `seguimiento`;
