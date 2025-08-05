-- إضافة 10 متدربين في جدول users مع تفعيل البريد الإلكتروني
INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `user_type_id`, `bio`, `country_id`, `city`, `phone_code`, `phone_number`, `created_at`, `updated_at`) VALUES
('{"ar":"متدرب 1"}', 'trainee1@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 3, 'نبذة عن المتدرب 1', 215, 'Rif Dimashq', '+90', '111111111', NOW(), NOW()),
('{"ar":"متدرب 2"}', 'trainee2@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 3, 'نبذة عن المتدرب 2', 215, 'Quneitra', '+90', '222222222', NOW(), NOW()),
('{"ar":"متدرب 3"}', 'trainee3@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 3, 'نبذة عن المتدرب 3', 18, 'Northern', '+90', '333333333', NOW(), NOW()),
('{"ar":"متدرب 4"}', 'trainee4@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 3, 'نبذة عن المتدرب 4', 16, 'Bilasuvar', '+90', '444444444', NOW(), NOW()),
('{"ar":"متدرب 5"}', 'trainee5@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 3, 'نبذة عن المتدرب 5', 12, 'Vayots Dzor', '+90', '555555555', NOW(), NOW()),
('{"ar":"متدرب 6"}', 'trainee6@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 3, 'نبذة عن المتدرب 6', 10, 'Saint George', '+90', '666666666', NOW(), NOW()),
('{"ar":"متدرب 7"}', 'trainee7@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 3, 'نبذة عن المتدرب 7', 3, 'Tirana', '+90', '777777777', NOW(), NOW()),
('{"ar":"متدرب 8"}', 'trainee8@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 3, 'نبذة عن المتدرب 8', 4, 'Algiers', '+90', '888888888', NOW(), NOW()),
('{"ar":"متدرب 9"}', 'trainee9@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 3, 'نبذة عن المتدرب 9', 1, 'Kabul', '+90', '999999999', NOW(), NOW()),
('{"ar":"متدرب 10"}', 'trainee10@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 3, 'نبذة عن المتدرب 10', 2, 'Mariehamn', '+90', '101010101', NOW(), NOW());

-- إضافة بيانات المتدربين في جدول trainees باستخدام الـ IDs التي تم إنشاؤها
INSERT INTO `trainees` (`id`, `last_name`, `sex`, `nationality`, `work_fields`, `education_levels_id`, `fields_of_interest`, `is_working`, `training_attendance`, `created_at`, `updated_at`)
SELECT 
    u.id, 
    '{"ar":"الاسم 1"}', 
    'ذكر', 
    '[\"2\"]', 
    '[\"3\"]', 
    2, 
    '[\"تحليل البيانات\"]', 
    1, 
    'حضوري', 
    NOW(), 
    NOW()
FROM `users` u WHERE u.email = 'trainee1@example.com';

INSERT INTO `trainees` (`id`, `last_name`, `sex`, `nationality`, `work_fields`, `education_levels_id`, `fields_of_interest`, `is_working`, `training_attendance`, `created_at`, `updated_at`)
SELECT 
    u.id, 
    '{"ar":"الاسم 2"}', 
    'أنثى', 
    '[\"2\"]', 
    '[\"3\"]', 
    2, 
    '[\"تحليل البيانات\"]', 
    0, 
    'عن بعد', 
    NOW(), 
    NOW()
FROM `users` u WHERE u.email = 'trainee2@example.com';

INSERT INTO `trainees` (`id`, `last_name`, `sex`, `nationality`, `work_fields`, `education_levels_id`, `fields_of_interest`, `is_working`, `training_attendance`, `created_at`, `updated_at`)
SELECT 
    u.id, 
    '{"ar":"الاسم 3"}', 
    'ذكر', 
    '[\"2\"]', 
    '[\"3\"]', 
    2, 
    '[\"تحليل البيانات\"]', 
    1, 
    'حضوري', 
    NOW(), 
    NOW()
FROM `users` u WHERE u.email = 'trainee3@example.com';

INSERT INTO `trainees` (`id`, `last_name`, `sex`, `nationality`, `work_fields`, `education_levels_id`, `fields_of_interest`, `is_working`, `training_attendance`, `created_at`, `updated_at`)
SELECT 
    u.id, 
    '{"ar":"الاسم 4"}', 
    'أنثى', 
    '[\"2\"]', 
    '[\"3\"]', 
    2, 
    '[\"تحليل البيانات\"]', 
    0, 
    'عن بعد', 
    NOW(), 
    NOW()
FROM `users` u WHERE u.email = 'trainee4@example.com';

INSERT INTO `trainees` (`id`, `last_name`, `sex`, `nationality`, `work_fields`, `education_levels_id`, `fields_of_interest`, `is_working`, `training_attendance`, `created_at`, `updated_at`)
SELECT 
    u.id, 
    '{"ar":"الاسم 5"}', 
    'ذكر', 
    '[\"2\"]', 
    '[\"3\"]', 
    2, 
    '[\"تحليل البيانات\"]', 
    1, 
    'حضوري', 
    NOW(), 
    NOW()
FROM `users` u WHERE u.email = 'trainee5@example.com';

INSERT INTO `trainees` (`id`, `last_name`, `sex`, `nationality`, `work_fields`, `education_levels_id`, `fields_of_interest`, `is_working`, `training_attendance`, `created_at`, `updated_at`)
SELECT 
    u.id, 
    '{"ar":"الاسم 6"}', 
    'أنثى', 
    '[\"2\"]', 
    '[\"3\"]', 
    2, 
    '[\"تحليل البيانات\"]', 
    0, 
    'عن بعد', 
    NOW(), 
    NOW()
FROM `users` u WHERE u.email = 'trainee6@example.com';

INSERT INTO `trainees` (`id`, `last_name`, `sex`, `nationality`, `work_fields`, `education_levels_id`, `fields_of_interest`, `is_working`, `training_attendance`, `created_at`, `updated_at`)
SELECT 
    u.id, 
    '{"ar":"الاسم 7"}', 
    'ذكر', 
    '[\"2\"]', 
    '[\"3\"]', 
    2, 
    '[\"تحليل البيانات\"]', 
    1, 
    'حضوري', 
    NOW(), 
    NOW()
FROM `users` u WHERE u.email = 'trainee7@example.com';

INSERT INTO `trainees` (`id`, `last_name`, `sex`, `nationality`, `work_fields`, `education_levels_id`, `fields_of_interest`, `is_working`, `training_attendance`, `created_at`, `updated_at`)
SELECT 
    u.id, 
    '{"ar":"الاسم 8"}', 
    'أنثى', 
    '[\"2\"]', 
    '[\"3\"]', 
    2, 
    '[\"تحليل البيانات\"]', 
    0, 
    'عن بعد', 
    NOW(), 
    NOW()
FROM `users` u WHERE u.email = 'trainee8@example.com';

INSERT INTO `trainees` (`id`, `last_name`, `sex`, `nationality`, `work_fields`, `education_levels_id`, `fields_of_interest`, `is_working`, `training_attendance`, `created_at`, `updated_at`)
SELECT 
    u.id, 
    '{"ar":"الاسم 9"}', 
    'ذكر', 
    '[\"2\"]', 
    '[\"3\"]', 
    2, 
    '[\"تحليل البيانات\"]', 
    1, 
    'حضوري', 
    NOW(), 
    NOW()
FROM `users` u WHERE u.email = 'trainee9@example.com';

INSERT INTO `trainees` (`id`, `last_name`, `sex`, `nationality`, `work_fields`, `education_levels_id`, `fields_of_interest`, `is_working`, `training_attendance`, `created_at`, `updated_at`)
SELECT 
    u.id, 
    '{"ar":"الاسم 10"}', 
    'أنثى', 
    '[\"2\"]', 
    '[\"3\"]', 
    2, 
    '[\"تحليل البيانات\"]', 
    0, 
    'عن بعد', 
    NOW(), 
    NOW()
FROM `users` u WHERE u.email = 'trainee10@example.com';

-- إضافة 10 منظمات في جدول users مع تفعيل البريد الإلكتروني
INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `user_type_id`, `bio`, `country_id`, `city`, `phone_code`, `phone_number`, `created_at`, `updated_at`) VALUES
('{"ar":"منظمة 1"}', 'org1@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 4, 'نبذة عن منظمة 1', 215, 'Rif Dimashq', '+90', '111111111', NOW(), NOW()),
('{"ar":"منظمة 2"}', 'org2@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 4, 'نبذة عن منظمة 2', 215, 'Quneitra', '+90', '222222222', NOW(), NOW()),
('{"ar":"منظمة 3"}', 'org3@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 4, 'نبذة عن منظمة 3', 18, 'Northern', '+90', '333333333', NOW(), NOW()),
('{"ar":"منظمة 4"}', 'org4@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 4, 'نبذة عن منظمة 4', 16, 'Bilasuvar', '+90', '444444444', NOW(), NOW()),
('{"ar":"منظمة 5"}', 'org5@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 4, 'نبذة عن منظمة 5', 12, 'Vayots Dzor', '+90', '555555555', NOW(), NOW()),
('{"ar":"منظمة 6"}', 'org6@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 4, 'نبذة عن منظمة 6', 10, 'Saint George', '+90', '666666666', NOW(), NOW()),
('{"ar":"منظمة 7"}', 'org7@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 4, 'نبذة عن منظمة 7', 3, 'Tirana', '+90', '777777777', NOW(), NOW()),
('{"ar":"منظمة 8"}', 'org8@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 4, 'نبذة عن منظمة 8', 4, 'Algiers', '+90', '888888888', NOW(), NOW()),
('{"ar":"منظمة 9"}', 'org9@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 4, 'نبذة عن منظمة 9', 1, 'Kabul', '+90', '999999999', NOW(), NOW()),
('{"ar":"منظمة 10"}', 'org10@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 4, 'نبذة عن منظمة 10', 2, 'Mariehamn', '+90', '101010101', NOW(), NOW());

-- إضافة بيانات المنظمات في جدول organizations باستخدام الـ IDs التي تم إنشاؤها
INSERT INTO `organizations` (`id`, `organization_type_id`, `website`, `employee_numbers_id`, `established_year`, `annual_budgets_id`, `organization_sectors`, `created_at`, `updated_at`)
SELECT u.id, 1, 'https://org1.com', 1, 2010, 1, '[\"1\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'org1@example.com';

INSERT INTO `organizations` (`id`, `organization_type_id`, `website`, `employee_numbers_id`, `established_year`, `annual_budgets_id`, `organization_sectors`, `created_at`, `updated_at`)
SELECT u.id, 2, 'https://org2.com', 2, 2011, 2, '[\"2\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'org2@example.com';

INSERT INTO `organizations` (`id`, `organization_type_id`, `website`, `employee_numbers_id`, `established_year`, `annual_budgets_id`, `organization_sectors`, `created_at`, `updated_at`)
SELECT u.id, 3, 'https://org3.com', 3, 2012, 3, '[\"3\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'org3@example.com';

INSERT INTO `organizations` (`id`, `organization_type_id`, `website`, `employee_numbers_id`, `established_year`, `annual_budgets_id`, `organization_sectors`, `created_at`, `updated_at`)
SELECT u.id, 4, 'https://org4.com', 4, 2013, 4, '[\"4\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'org4@example.com';

INSERT INTO `organizations` (`id`, `organization_type_id`, `website`, `employee_numbers_id`, `established_year`, `annual_budgets_id`, `organization_sectors`, `created_at`, `updated_at`)
SELECT u.id, 5, 'https://org5.com', 5, 2014, 1, '[\"5\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'org5@example.com';

INSERT INTO `organizations` (`id`, `organization_type_id`, `website`, `employee_numbers_id`, `established_year`, `annual_budgets_id`, `organization_sectors`, `created_at`, `updated_at`)
SELECT u.id, 1, 'https://org6.com', 1, 2015, 2, '[\"1\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'org6@example.com';

INSERT INTO `organizations` (`id`, `organization_type_id`, `website`, `employee_numbers_id`, `established_year`, `annual_budgets_id`, `organization_sectors`, `created_at`, `updated_at`)
SELECT u.id, 2, 'https://org7.com', 2, 2016, 3, '[\"2\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'org7@example.com';

INSERT INTO `organizations` (`id`, `organization_type_id`, `website`, `employee_numbers_id`, `established_year`, `annual_budgets_id`, `organization_sectors`, `created_at`, `updated_at`)
SELECT u.id, 3, 'https://org8.com', 3, 2017, 4, '[\"3\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'org8@example.com';

INSERT INTO `organizations` (`id`, `organization_type_id`, `website`, `employee_numbers_id`, `established_year`, `annual_budgets_id`, `organization_sectors`, `created_at`, `updated_at`)
SELECT u.id, 4, 'https://org9.com', 4, 2018, 1, '[\"4\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'org9@example.com';

INSERT INTO `organizations` (`id`, `organization_type_id`, `website`, `employee_numbers_id`, `established_year`, `annual_budgets_id`, `organization_sectors`, `created_at`, `updated_at`)
SELECT u.id, 5, 'https://org10.com', 5, 2019, 2, '[\"5\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'org10@example.com';

-- إضافة 10 مساعدين في جدول users مع تفعيل البريد الإلكتروني
INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `user_type_id`, `bio`, `country_id`, `city`, `phone_code`, `phone_number`, `created_at`, `updated_at`) VALUES
('{"ar":"مساعد 1"}', 'assistant1@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 2, 'نبذة عن مساعد 1', 215, 'Rif Dimashq', '+90', '111111111', NOW(), NOW()),
('{"ar":"مساعد 2"}', 'assistant2@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 2, 'نبذة عن مساعد 2', 215, 'Quneitra', '+90', '222222222', NOW(), NOW()),
('{"ar":"مساعد 3"}', 'assistant3@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 2, 'نبذة عن مساعد 3', 18, 'Northern', '+90', '333333333', NOW(), NOW()),
('{"ar":"مساعد 4"}', 'assistant4@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 2, 'نبذة عن مساعد 4', 16, 'Bilasuvar', '+90', '444444444', NOW(), NOW()),
('{"ar":"مساعد 5"}', 'assistant5@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 2, 'نبذة عن مساعد 5', 12, 'Vayots Dzor', '+90', '555555555', NOW(), NOW()),
('{"ar":"مساعد 6"}', 'assistant6@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 2, 'نبذة عن مساعد 6', 10, 'Saint George', '+90', '666666666', NOW(), NOW()),
('{"ar":"مساعد 7"}', 'assistant7@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 2, 'نبذة عن مساعد 7', 3, 'Tirana', '+90', '777777777', NOW(), NOW()),
('{"ar":"مساعد 8"}', 'assistant8@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 2, 'نبذة عن مساعد 8', 4, 'Algiers', '+90', '888888888', NOW(), NOW()),
('{"ar":"مساعد 9"}', 'assistant9@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 2, 'نبذة عن مساعد 9', 1, 'Kabul', '+90', '999999999', NOW(), NOW()),
('{"ar":"مساعد 10"}', 'assistant10@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 2, 'نبذة عن مساعد 10', 2, 'Mariehamn', '+90', '101010101', NOW(), NOW());

-- إضافة بيانات المساعدين في جدول assistants باستخدام الـ IDs التي تم إنشاؤها
INSERT INTO `assistants` (`id`, `last_name`, `sex`, `headline`, `nationality`, `years_of_experience`, `experience_areas`, `provided_services`, `specialization`, `university`, `graduation_year`, `education_levels_id`, `languages`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 1"}', 'ذكر', 'عنوان مساعد 1', '[\"2\"]', 2, '[\"3\"]', '[\"3\"]', 'تخصص 1', 'جامعة 1', '2020-01-01', 2, '[\"2\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'assistant1@example.com';

INSERT INTO `assistants` (`id`, `last_name`, `sex`, `headline`, `nationality`, `years_of_experience`, `experience_areas`, `provided_services`, `specialization`, `university`, `graduation_year`, `education_levels_id`, `languages`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 2"}', 'أنثى', 'عنوان مساعد 2', '[\"2\"]', 3, '[\"3\"]', '[\"2\"]', 'تخصص 2', 'جامعة 2', '2019-01-01', 2, '[\"1\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'assistant2@example.com';

INSERT INTO `assistants` (`id`, `last_name`, `sex`, `headline`, `nationality`, `years_of_experience`, `experience_areas`, `provided_services`, `specialization`, `university`, `graduation_year`, `education_levels_id`, `languages`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 3"}', 'ذكر', 'عنوان مساعد 3', '[\"2\"]', 4, '[\"3\"]', '[\"3\"]', 'تخصص 3', 'جامعة 3', '2018-01-01', 2, '[\"2\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'assistant3@example.com';

INSERT INTO `assistants` (`id`, `last_name`, `sex`, `headline`, `nationality`, `years_of_experience`, `experience_areas`, `provided_services`, `specialization`, `university`, `graduation_year`, `education_levels_id`, `languages`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 4"}', 'أنثى', 'عنوان مساعد 4', '[\"2\"]', 5, '[\"3\"]', '[\"1\"]', 'تخصص 4', 'جامعة 4', '2017-01-01', 2, '[\"1\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'assistant4@example.com';

INSERT INTO `assistants` (`id`, `last_name`, `sex`, `headline`, `nationality`, `years_of_experience`, `experience_areas`, `provided_services`, `specialization`, `university`, `graduation_year`, `education_levels_id`, `languages`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 5"}', 'ذكر', 'عنوان مساعد 5', '[\"2\"]', 6, '[\"3\"]', '[\"2\"]', 'تخصص 5', 'جامعة 5', '2016-01-01', 2, '[\"2\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'assistant5@example.com';

INSERT INTO `assistants` (`id`, `last_name`, `sex`, `headline`, `nationality`, `years_of_experience`, `experience_areas`, `provided_services`, `specialization`, `university`, `graduation_year`, `education_levels_id`, `languages`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 6"}', 'أنثى', 'عنوان مساعد 6', '[\"2\"]', 7, '[\"3\"]', '[\"3\"]', 'تخصص 6', 'جامعة 6', '2015-01-01', 2, '[\"1\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'assistant6@example.com';

INSERT INTO `assistants` (`id`, `last_name`, `sex`, `headline`, `nationality`, `years_of_experience`, `experience_areas`, `provided_services`, `specialization`, `university`, `graduation_year`, `education_levels_id`, `languages`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 7"}', 'ذكر', 'عنوان مساعد 7', '[\"2\"]', 8, '[\"3\"]', '[\"1\"]', 'تخصص 7', 'جامعة 7', '2014-01-01', 2, '[\"2\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'assistant7@example.com';

INSERT INTO `assistants` (`id`, `last_name`, `sex`, `headline`, `nationality`, `years_of_experience`, `experience_areas`, `provided_services`, `specialization`, `university`, `graduation_year`, `education_levels_id`, `languages`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 8"}', 'أنثى', 'عنوان مساعد 8', '[\"2\"]', 9, '[\"3\"]', '[\"2\"]', 'تخصص 8', 'جامعة 8', '2013-01-01', 2, '[\"1\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'assistant8@example.com';

INSERT INTO `assistants` (`id`, `last_name`, `sex`, `headline`, `nationality`, `years_of_experience`, `experience_areas`, `provided_services`, `specialization`, `university`, `graduation_year`, `education_levels_id`, `languages`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 9"}', 'ذكر', 'عنوان مساعد 9', '[\"2\"]', 10, '[\"3\"]', '[\"3\"]', 'تخصص 9', 'جامعة 9', '2012-01-01', 2, '[\"2\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'assistant9@example.com';

INSERT INTO `assistants` (`id`, `last_name`, `sex`, `headline`, `nationality`, `years_of_experience`, `experience_areas`, `provided_services`, `specialization`, `university`, `graduation_year`, `education_levels_id`, `languages`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 10"}', 'أنثى', 'عنوان مساعد 10', '[\"2\"]', 11, '[\"3\"]', '[\"1\"]', 'تخصص 10', 'جامعة 10', '2011-01-01', 2, '[\"1\"]', NOW(), NOW() FROM `users` u WHERE u.email = 'assistant10@example.com';


-- إضافة 10 مدربين في جدول users مع تفعيل البريد الإلكتروني
INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `user_type_id`, `bio`, `country_id`, `city`, `phone_code`, `phone_number`, `created_at`, `updated_at`) VALUES
('{"ar":"مدرب 1"}', 'trainer1@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 1, 'نبذة عن مدرب 1', 215, 'Rif Dimashq', '+90', '111111111', NOW(), NOW()),
('{"ar":"مدرب 2"}', 'trainer2@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 1, 'نبذة عن مدرب 2', 215, 'Quneitra', '+90', '222222222', NOW(), NOW()),
('{"ar":"مدرب 3"}', 'trainer3@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 1, 'نبذة عن مدرب 3', 18, 'Northern', '+90', '333333333', NOW(), NOW()),
('{"ar":"مدرب 4"}', 'trainer4@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 1, 'نبذة عن مدرب 4', 16, 'Bilasuvar', '+90', '444444444', NOW(), NOW()),
('{"ar":"مدرب 5"}', 'trainer5@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 1, 'نبذة عن مدرب 5', 12, 'Vayots Dzor', '+90', '555555555', NOW(), NOW()),
('{"ar":"مدرب 6"}', 'trainer6@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 1, 'نبذة عن مدرب 6', 10, 'Saint George', '+90', '666666666', NOW(), NOW()),
('{"ar":"مدرب 7"}', 'trainer7@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 1, 'نبذة عن مدرب 7', 3, 'Tirana', '+90', '777777777', NOW(), NOW()),
('{"ar":"مدرب 8"}', 'trainer8@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 1, 'نبذة عن مدرب 8', 4, 'Algiers', '+90', '888888888', NOW(), NOW()),
('{"ar":"مدرب 9"}', 'trainer9@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 1, 'نبذة عن مدرب 9', 1, 'Kabul', '+90', '999999999', NOW(), NOW()),
('{"ar":"مدرب 10"}', 'trainer10@example.com', NOW(), '$2y$12$JmpXdzLlxxsUN.yWg1zKf.MQZgSPKUU46o4JFbpPsJ9ZjTQAB5SD6', 1, 'نبذة عن مدرب 10', 2, 'Mariehamn', '+90', '101010101', NOW(), NOW());

-- إضافة بيانات المدربين في جدول trainers باستخدام الـ IDs التي تم إنشاؤها
INSERT INTO `trainers` (`id`, `last_name`, `sex`, `headline`, `nationality`, `work_sectors`, `provided_services`, `work_fields`, `international_exp`, `important_topics`, `hourly_wage`, `currency`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 1"}', 'ذكر', 'عنوان مدرب 1', '[\"2\"]', '[\"3\"]', '[\"3\"]', '[\"3\"]', '[\"3\"]', '[\"تطوير الويب\"]', 100.00, 'ريال', NOW(), NOW() FROM `users` u WHERE u.email = 'trainer1@example.com';

INSERT INTO `trainers` (`id`, `last_name`, `sex`, `headline`, `nationality`, `work_sectors`, `provided_services`, `work_fields`, `international_exp`, `important_topics`, `hourly_wage`, `currency`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 2"}', 'أنثى', 'عنوان مدرب 2', '[\"2\"]', '[\"2\"]', '[\"2\"]', '[\"2\"]', '[\"2\"]', '[\"تحليل البيانات\"]', 150.00, 'ريال', NOW(), NOW() FROM `users` u WHERE u.email = 'trainer2@example.com';

INSERT INTO `trainers` (`id`, `last_name`, `sex`, `headline`, `nationality`, `work_sectors`, `provided_services`, `work_fields`, `international_exp`, `important_topics`, `hourly_wage`, `currency`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 3"}', 'ذكر', 'عنوان مدرب 3', '[\"2\"]', '[\"3\"]', '[\"3\"]', '[\"3\"]', '[\"3\"]', '[\"الإدارة والقيادة\"]', 200.00, 'ريال', NOW(), NOW() FROM `users` u WHERE u.email = 'trainer3@example.com';

INSERT INTO `trainers` (`id`, `last_name`, `sex`, `headline`, `nationality`, `work_sectors`, `provided_services`, `work_fields`, `international_exp`, `important_topics`, `hourly_wage`, `currency`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 4"}', 'أنثى', 'عنوان مدرب 4', '[\"2\"]', '[\"1\"]', '[\"1\"]', '[\"4\"]', '[\"4\"]', '[\"التسويق الرقمي\"]', 250.00, 'ريال', NOW(), NOW() FROM `users` u WHERE u.email = 'trainer4@example.com';

INSERT INTO `trainers` (`id`, `last_name`, `sex`, `headline`, `nationality`, `work_sectors`, `provided_services`, `work_fields`, `international_exp`, `important_topics`, `hourly_wage`, `currency`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 5"}', 'ذكر', 'عنوان مدرب 5', '[\"2\"]', '[\"2\"]', '[\"2\"]', '[\"5\"]', '[\"5\"]', '[\"المالية والمحاسبة\"]', 300.00, 'ريال', NOW(), NOW() FROM `users` u WHERE u.email = 'trainer5@example.com';

INSERT INTO `trainers` (`id`, `last_name`, `sex`, `headline`, `nationality`, `work_sectors`, `provided_services`, `work_fields`, `international_exp`, `important_topics`, `hourly_wage`, `currency`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 6"}', 'أنثى', 'عنوان مدرب 6', '[\"2\"]', '[\"3\"]', '[\"3\"]', '[\"6\"]', '[\"1\"]', '[\"تطوير الويب\"]', 350.00, 'ريال', NOW(), NOW() FROM `users` u WHERE u.email = 'trainer6@example.com';

INSERT INTO `trainers` (`id`, `last_name`, `sex`, `headline`, `nationality`, `work_sectors`, `provided_services`, `work_fields`, `international_exp`, `important_topics`, `hourly_wage`, `currency`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 7"}', 'ذكر', 'عنوان مدرب 7', '[\"2\"]', '[\"1\"]', '[\"1\"]', '[\"1\"]', '[\"2\"]', '[\"تحليل البيانات\"]', 400.00, 'ريال', NOW(), NOW() FROM `users` u WHERE u.email = 'trainer7@example.com';

INSERT INTO `trainers` (`id`, `last_name`, `sex`, `headline`, `nationality`, `work_sectors`, `provided_services`, `work_fields`, `international_exp`, `important_topics`, `hourly_wage`, `currency`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 8"}', 'أنثى', 'عنوان مدرب 8', '[\"2\"]', '[\"2\"]', '[\"2\"]', '[\"2\"]', '[\"3\"]', '[\"الإدارة والقيادة\"]', 450.00, 'ريال', NOW(), NOW() FROM `users` u WHERE u.email = 'trainer8@example.com';

INSERT INTO `trainers` (`id`, `last_name`, `sex`, `headline`, `nationality`, `work_sectors`, `provided_services`, `work_fields`, `international_exp`, `important_topics`, `hourly_wage`, `currency`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 9"}', 'ذكر', 'عنوان مدرب 9', '[\"2\"]', '[\"3\"]', '[\"3\"]', '[\"3\"]', '[\"4\"]', '[\"التسويق الرقمي\"]', 500.00, 'ريال', NOW(), NOW() FROM `users` u WHERE u.email = 'trainer9@example.com';

INSERT INTO `trainers` (`id`, `last_name`, `sex`, `headline`, `nationality`, `work_sectors`, `provided_services`, `work_fields`, `international_exp`, `important_topics`, `hourly_wage`, `currency`, `created_at`, `updated_at`)
SELECT u.id, '{"ar":"الاسم 10"}', 'أنثى', 'عنوان مدرب 10', '[\"2\"]', '[\"1\"]', '[\"1\"]', '[\"4\"]', '[\"5\"]', '[\"المالية والمحاسبة\"]', 550.00, 'ريال', NOW(), NOW() FROM `users` u WHERE u.email = 'trainer10@example.com';