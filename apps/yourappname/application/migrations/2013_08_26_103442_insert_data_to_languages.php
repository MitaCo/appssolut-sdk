<?php

class Insert_Data_To_Languages {

	public function up()
	{
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (1, 'default', '', 'All', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (2, 'af_ZA', '', 'Afrikaans', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (3, 'az_AZ', '', 'Azərbaycan dili', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (4, 'id_ID', '', 'Bahasa Indonesia', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (5, 'ms_MY', '', 'Bahasa Melayu', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (6, 'bs_BA', '', 'Bosanski', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (7, 'ca_ES', '', 'Català', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (8, 'cy_GB', '', 'Cymraeg', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (9, 'cs_CZ', '', 'Čeština', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (10, 'da_DK', '', 'Dansk', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (11, 'de_DE', '', 'Deutsch', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (12, 'et_EE', '', 'Eesti', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (13, 'en_PI', '', 'English (Pirate)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (14, 'en_GB', '', 'English (UK)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (15, 'en_UD', '', 'English (Upside Down)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (16, 'en_US', '', 'English (US)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (17, 'es_LA', '', 'Español', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (18, 'es_ES', '', 'Español (España)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (19, 'eo_EO', '', 'Esperanto', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (20, 'eu_ES', '', 'Euskara', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (21, 'tl_PH', '', 'Filipino', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (22, 'fo_FO', '', 'Føroyskt', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (23, 'fr_CA', '', 'Français (Canada)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (24, 'fr_FR', '', 'Français (France)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (25, 'fy_NL', '', 'Frysk', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (26, 'ga_IE', '', 'Gaeilge', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (27, 'gl_ES', '', 'Galego', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (28, 'hr_HR', '', 'Hrvatski', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (29, 'is_IS', '', 'Íslenska', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (30, 'it_IT', '', 'Italiano', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (31, 'sw_KE', '', 'Kiswahili', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (32, 'ku_TR', '', 'Kurdî', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (33, 'lv_LV', '', 'Latviešu', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (34, 'fb_LT', '', 'Leet Speak', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (35, 'lt_LT', '', 'Lietuvių', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (36, 'la_VA', '', 'lingua latina', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (37, 'hu_HU', '', 'Magyar', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (38, 'nl_NL', '', 'Nederlands', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (39, 'nb_NO', '', 'Norsk (bokmål)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (40, 'nn_NO', '', 'Norsk (nynorsk)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (41, 'pl_PL', '', 'Polski', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (42, 'pt_BR', '', 'Português (Brasil)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (43, 'pt_PT', '', 'Português (Portugal)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (44, 'ro_RO', '', 'Română', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (45, 'sq_AL', '', 'Shqip', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (46, 'sk_SK', '', 'Slovenčina', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (47, 'sl_SI', '', 'Slovenščina', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (48, 'fi_FI', '', 'Suomi', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (49, 'sv_SE', '', 'Svenska', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (50, 'vi_VN', '', 'Tiếng Việt', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (51, 'tr_TR', '', 'Türkçe', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (52, 'el_GR', '', 'Ελληνικά', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (53, 'be_BY', '', 'Беларуская', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (54, 'bg_BG', '', 'Български', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (55, 'mk_MK', '', 'Македонски', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (56, 'ru_RU', '', 'Русский', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (57, 'sr_RS', '', 'Српски', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (58, 'uk_UA', '', 'Українська', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (59, 'ka_GE', '', 'ქართული', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (60, 'hy_AM', '', 'Հայերեն', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (61, 'he_IL', '', 'עברית', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (62, 'ar_AR', '', 'العربية', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (63, 'ps_AF', '', 'پښتو', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (64, 'fa_IR', '', 'فارسی', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (65, 'ne_NP', '', 'नेपाली', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (66, 'hi_IN', '', 'हिन्दी', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (67, 'bn_IN', '', 'বাংলা', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (68, 'pa_IN', '', 'ਪੰਜਾਬੀ', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (69, 'ta_IN', '', 'தமிழ்', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (70, 'te_IN', '', 'తెలుగు', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (71, 'ml_IN', '', 'മലയാളം', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (72, 'th_TH', '', 'ภาษาไทย', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (73, 'km_KH', '', 'ភាសាខ្មែរ', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (74, 'ko_KR', '', '한국어', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (75, 'zh_TW', '', '中文(台灣)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (76, 'zh_CN', '', '中文(简体)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (77, 'zh_HK', '', '中文(香港)', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");
        DB::query("insert into languages (id, langcode, address_code, name, created_at, updated_at) values (78, 'ja_JP', '', '日本語', '2013-06-13 12:00:03', '2013-06-13 12:00:03');");

        DB::query("SELECT setval('languages_id_seq', 78);");
    }

	public function down()
	{
		//
	}

}