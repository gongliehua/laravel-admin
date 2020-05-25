/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : laravel_admin

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 26/05/2020 00:48:28
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_configs
-- ----------------------------
DROP TABLE IF EXISTS `admin_configs`;
CREATE TABLE `admin_configs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
  `variable` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '变量名',
  `type` tinyint(3) NOT NULL DEFAULT 1 COMMENT '类型:1=单行文本框,2=多行文本框,3=单选按钮,4=复选框,5=下拉菜单',
  `item` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '可选项',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '配置值',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序(升序)',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_configs
-- ----------------------------
INSERT INTO `admin_configs` VALUES (7, '1', 'fasd', 1, '1', NULL, 123, '2020-05-25 17:33:07', '2020-05-25 22:43:44', NULL);

-- ----------------------------
-- Table structure for admin_operation_logs
-- ----------------------------
DROP TABLE IF EXISTS `admin_operation_logs`;
CREATE TABLE `admin_operation_logs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `method` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '类型',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '路径',
  `input` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '数据',
  `admin_user_id` int(11) NOT NULL COMMENT '管理员ID(操作的人)',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '操作日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_operation_logs
-- ----------------------------
INSERT INTO `admin_operation_logs` VALUES (1, 'fdsa', 'dfsa', 's', 's', 1, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '父ID',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `slug` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '标识',
  `icon` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '图标',
  `is_menu` tinyint(3) NOT NULL DEFAULT 2 COMMENT '菜单:1=是,2=否',
  `status` tinyint(3) NOT NULL DEFAULT 1 COMMENT '状态:1=正常,2=禁用',
  `remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序(升序)',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '权限表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
INSERT INTO `admin_permissions` VALUES (1, 0, '用户管理', NULL, 'fa-circle-o', 1, 1, NULL, 1, '2020-05-25 23:14:07', '2020-05-25 23:22:28', NULL);
INSERT INTO `admin_permissions` VALUES (2, 1, '权限管理', NULL, 'fa-circle-o', 1, 1, NULL, 1, '2020-05-25 23:15:05', '2020-05-25 23:30:56', '2020-05-25 23:30:56');
INSERT INTO `admin_permissions` VALUES (3, 0, '系统管理', NULL, 'fa-circle-o', 1, 1, NULL, 2, '2020-05-26 00:17:20', '2020-05-26 00:17:20', NULL);
INSERT INTO `admin_permissions` VALUES (4, 1, '用户列表', NULL, 'fa-circle-o', 1, 1, NULL, 3, '2020-05-26 00:17:30', '2020-05-26 00:17:30', NULL);
INSERT INTO `admin_permissions` VALUES (5, 1, '角色管理', NULL, 'fa-circle-o', 1, 1, NULL, 4, '2020-05-26 00:17:42', '2020-05-26 00:17:42', NULL);
INSERT INTO `admin_permissions` VALUES (6, 1, '权限管理', NULL, 'fa-circle-o', 1, 1, NULL, 5, '2020-05-26 00:17:57', '2020-05-26 00:17:57', NULL);
INSERT INTO `admin_permissions` VALUES (7, 3, '系统设置', NULL, 'fa-circle-o', 1, 1, NULL, 6, '2020-05-26 00:18:08', '2020-05-26 00:18:08', NULL);
INSERT INTO `admin_permissions` VALUES (8, 3, '操作日志', NULL, 'fa-circle-o', 1, 1, NULL, 7, '2020-05-26 00:18:18', '2020-05-26 00:18:18', NULL);

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions`  (
  `admin_role_id` int(11) NOT NULL COMMENT '角色ID',
  `admin_permission_id` int(11) NOT NULL COMMENT '权限ID',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色和权限的关系表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users`  (
  `admin_role_id` int(11) NOT NULL COMMENT '角色ID',
  `admin_user_id` int(11) NOT NULL COMMENT '管理员ID',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色和管理员的关系表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `status` tinyint(3) NOT NULL DEFAULT 1 COMMENT '状态:1=正常,2=禁用',
  `remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES (1, '所有权限', 1, NULL, '2020-05-26 00:20:28', '2020-05-26 00:43:26', '2020-05-26 00:43:26');
INSERT INTO `admin_roles` VALUES (2, 'dfsas', 2, 'a', '2020-05-26 00:39:32', '2020-05-26 00:43:20', '2020-05-26 00:43:20');

-- ----------------------------
-- Table structure for admin_user_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_permissions`;
CREATE TABLE `admin_user_permissions`  (
  `admin_user_id` int(11) NOT NULL COMMENT '管理员ID',
  `admin_permission_id` int(11) NOT NULL COMMENT '权限ID',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '管理员和权限的关系表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '姓名',
  `sex` tinyint(3) NOT NULL DEFAULT 0 COMMENT '性别:0=保密,1=男,2=女',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '头像',
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '电子邮箱',
  `status` tinyint(3) NOT NULL DEFAULT 1 COMMENT '状态:1=正常,2=禁用',
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'token',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES (1, 'admin', '$2y$10$Mun7UHf8Yb6GE/jg6p3JEuzjCd/K9aMVQBxqQ7Sh7Eh9b0dyYW83O', '默认管理员', 0, NULL, NULL, 1, 'rn2uwecAGGQpB9gGS68u6bPLZRUxzbOUs0oiqJjHJJdJR90EJUCaIa486xza', '2020-05-25 12:00:00', '2020-05-25 13:28:50', NULL);

SET FOREIGN_KEY_CHECKS = 1;
