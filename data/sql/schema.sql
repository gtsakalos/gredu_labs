CREATE TABLE `school` (
    `id` integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `registryNo` varchar(255) NOT NULL,
    `streetAddress` varchar(255),
    `phoneNumber` varchar(255),
    `faxNumber` varchar(255),
    `email` varchar(255),
    `educationLevel` varchar(255) NOT NULL,
    `unitType` varchar(255) NOT NULL,
    `category` varchar(255) NOT NULL,
    `eduAdmin` varchar(255) NOT NULL,
    `regionEduAdmin` varchar(255) NOT NULL
)
;
CREATE TABLE `teacher` (
    `id` integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `school_id` integer NOT NULL,
    `name` varchar(255) NOT NULL,
    `surname` varchar(255) NOT NULL,
    `speciality` varchar(255) NOT NULL,
    `phoneNumber` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `labSupervisor` bool NOT NULL,
    `schoolPrincipal` bool NOT NULL
)
;
ALTER TABLE `teacher` ADD CONSTRAINT `school_id_refs_id_6cf9093d` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`);
CREATE TABLE `lab` (
    `id` integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `labName` varchar(255) NOT NULL,
    `school_id` integer NOT NULL,
    `labSupervisor_id` integer NOT NULL,
    `area` integer NOT NULL
)
;
ALTER TABLE `lab` ADD CONSTRAINT `school_id_refs_id_670c638a` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`);
ALTER TABLE `lab` ADD CONSTRAINT `labSupervisor_id_refs_id_17f65f44` FOREIGN KEY (`labSupervisor_id`) REFERENCES `teacher` (`id`);
CREATE TABLE `itemCategory` (
    `id` integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `name` varchar(255) NOT NULL
)
;
CREATE TABLE `application` (
    `id` integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `school_id` integer NOT NULL,
    `created_at` datetime NOT NULL,
    `modified_at` datetime NOT NULL,
    `apply_for` varchar(255) NOT NULL,
    `new_lab` bool NOT NULL,
    `comments` longtext
)
;
ALTER TABLE `application` ADD CONSTRAINT `school_id_refs_id_c55b46c6` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`);
CREATE TABLE `applicationItem` (
    `id` integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `application_id` integer NOT NULL,
    `lab_id` integer NOT NULL,
    `category_id` integer NOT NULL,
    `quantity` integer NOT NULL
)
;
ALTER TABLE `applicationItem` ADD CONSTRAINT `category_id_refs_id_e1f1b2d8` FOREIGN KEY (`category_id`) REFERENCES `itemCategory` (`id`);
ALTER TABLE `applicationItem` ADD CONSTRAINT `application_id_refs_id_2825a74c` FOREIGN KEY (`application_id`) REFERENCES `application` (`id`);
ALTER TABLE `applicationItem` ADD CONSTRAINT `lab_id_refs_id_08380f26` FOREIGN KEY (`lab_id`) REFERENCES `lab` (`id`);
