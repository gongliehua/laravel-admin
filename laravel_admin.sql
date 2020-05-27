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

 Date: 27/05/2020 18:24:41
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions`  (
  `admin_id` int(11) NOT NULL COMMENT '管理员ID',
  `permission_id` int(11) NOT NULL COMMENT '权限ID',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '管理员和权限的关系表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins`  (
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
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES (1, 'admin', '$2y$10$go4kR6XbqWjuj5ZbysPU/eZnNNr9/cNN9pmjoMJFLzyRIz81QRJPq', '默认管理员', 0, NULL, NULL, 1, NULL, '2020-05-27 18:15:26', '2020-05-27 18:15:28', NULL);

-- ----------------------------
-- Table structure for configs
-- ----------------------------
DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
  `variable` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '变量名',
  `type` tinyint(3) NOT NULL DEFAULT 1 COMMENT '类型:1=单行文本框,2=多行文本框,3=单选按钮,4=复选框,5=下拉菜单',
  `item` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '可选项',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '配置值',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序(升序)',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for operation_logs
-- ----------------------------
DROP TABLE IF EXISTS `operation_logs`;
CREATE TABLE `operation_logs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
  `method` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '类型',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '路径',
  `input` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '数据',
  `admin_id` int(11) NOT NULL COMMENT '管理员ID(操作的人)',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '操作日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '父ID',
  `title` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
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
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '权限表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 0, '清空缓存', 'admin.clear_cache', 'fa-circle-o', 2, 1, NULL, 10, '2020-05-27 18:16:01', '2020-05-27 18:22:10', NULL);
INSERT INTO `permissions` VALUES (2, 18, '用户管理', 'admin.admin', 'fa-circle-o', 1, 1, NULL, 10, '2020-05-27 18:16:01', '2020-05-27 18:18:21', NULL);
INSERT INTO `permissions` VALUES (3, 2, '用户添加', 'admin.admin.create', 'fa-circle-o', 2, 1, NULL, 11, '2020-05-27 18:16:01', '2020-05-27 18:18:50', NULL);
INSERT INTO `permissions` VALUES (4, 2, '用户查看', 'admin.admin.show', 'fa-circle-o', 2, 1, NULL, 100, '2020-05-27 18:16:01', '2020-05-27 18:19:34', NULL);
INSERT INTO `permissions` VALUES (5, 2, '用户修改', 'admin.admin.update', 'fa-circle-o', 2, 1, NULL, 100, '2020-05-27 18:16:01', '2020-05-27 18:19:45', NULL);
INSERT INTO `permissions` VALUES (6, 2, '用户删除', 'admin.admin.delete', 'fa-circle-o', 2, 1, NULL, 100, '2020-05-27 18:16:01', '2020-05-27 18:20:01', NULL);
INSERT INTO `permissions` VALUES (7, 18, '角色管理', 'admin.role', 'fa-circle-o', 1, 1, NULL, 100, '2020-05-27 18:16:01', '2020-05-27 18:20:21', NULL);
INSERT INTO `permissions` VALUES (8, 7, '角色添加', 'admin.role.create', 'fa-circle-o', 2, 1, NULL, 100, '2020-05-27 18:16:01', '2020-05-27 18:20:37', NULL);
INSERT INTO `permissions` VALUES (9, 7, '角色查看', 'admin.role.show', 'fa-circle-o', 2, 1, NULL, 100, '2020-05-27 18:16:01', '2020-05-27 18:20:49', NULL);
INSERT INTO `permissions` VALUES (10, 7, '角色修改', 'admin.role.update', 'fa-circle-o', 2, 1, NULL, 100, '2020-05-27 18:16:01', '2020-05-27 18:21:03', NULL);
INSERT INTO `permissions` VALUES (11, 7, '角色删除', 'admin.role.delete', 'fa-circle-o', 2, 1, NULL, 100, '2020-05-27 18:16:01', '2020-05-27 18:21:13', NULL);
INSERT INTO `permissions` VALUES (12, 18, '权限管理', 'admin.permission', 'fa-circle-o', 1, 1, NULL, 100, '2020-05-27 18:16:01', '2020-05-27 18:21:24', NULL);
INSERT INTO `permissions` VALUES (13, 12, '权限查看', 'admin.permission.show', 'fa-circle-o', 2, 1, NULL, 100, '2020-05-27 18:16:01', '2020-05-27 18:21:48', NULL);
INSERT INTO `permissions` VALUES (14, 12, '权限修改', 'admin.permission.update', 'fa-circle-o', 2, 1, NULL, 100, '2020-05-27 18:16:02', '2020-05-27 18:22:39', NULL);
INSERT INTO `permissions` VALUES (15, 19, '系统设置', 'admin.setting', 'fa-circle-o', 1, 1, NULL, 100, '2020-05-27 18:16:02', '2020-05-27 18:23:31', NULL);
INSERT INTO `permissions` VALUES (16, 19, '日志列表', 'admin.operation_log', 'fa-circle-o', 1, 1, NULL, 100, '2020-05-27 18:16:02', '2020-05-27 18:23:48', NULL);
INSERT INTO `permissions` VALUES (17, 16, '日常查看', 'admin.operation_log.show', 'fa-circle-o', 2, 1, NULL, 100, '2020-05-27 18:16:02', '2020-05-27 18:23:58', NULL);
INSERT INTO `permissions` VALUES (18, 0, '管理员管理', NULL, 'fa-group', 1, 1, NULL, 10, '2020-05-27 18:17:10', '2020-05-27 18:17:10', NULL);
INSERT INTO `permissions` VALUES (19, 0, '系统管理', NULL, 'fa-gears', 1, 1, NULL, 11, '2020-05-27 18:17:37', '2020-05-27 18:17:37', NULL);

-- ----------------------------
-- Table structure for role_admins
-- ----------------------------
DROP TABLE IF EXISTS `role_admins`;
CREATE TABLE `role_admins`  (
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `admin_id` int(11) NOT NULL COMMENT '管理员ID',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色和管理员的关系表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions`  (
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `permission_id` int(11) NOT NULL COMMENT '权限ID',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色和权限的关系表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `status` tinyint(3) NOT NULL DEFAULT 1 COMMENT '状态:1=正常,2=禁用',
  `remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
