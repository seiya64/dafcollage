-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `course` bigint(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `intro` longtext COLLATE utf8_unicode_ci,
  `introformat` smallint(4) NOT NULL DEFAULT '0',
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `mdl_voca_cou_ix` (`course`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Default comment for vocabulario, please edit me' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_adjetivos`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_adjetivos` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `sin_declinar` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `significado` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observaciones` longtext COLLATE utf8_unicode_ci,
  `gramaticaid` bigint(10) DEFAULT NULL,
  `intencionid` bigint(10) DEFAULT NULL,
  `tipologiaid` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_vocaadje_gra_ix` (`gramaticaid`),
  KEY `mdl_vocaadje_int_ix` (`intencionid`),
  KEY `mdl_vocaadje_tip_ix` (`tipologiaid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='adjetivo' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_camposlexicos_de`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_camposlexicos_de` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `campo` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_vocacampde_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='campos lexicos disponibles aleman' AUTO_INCREMENT=213 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_camposlexicos_en`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_camposlexicos_en` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `campo` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_vocacampen_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='campos lexicos disponibles en ingles' AUTO_INCREMENT=213 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_camposlexicos_es`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_camposlexicos_es` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `campo` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_vocacampes_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='campos lexicos disponibles en español' AUTO_INCREMENT=213 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_camposlexicos_fr`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_camposlexicos_fr` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `campo` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_vocacampfr_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='campos lexicos disponibles frances' AUTO_INCREMENT=213 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_camposlexicos_pl`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_camposlexicos_pl` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `campo` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_vocacamppl_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='campos lexicos disponibles en polaco' AUTO_INCREMENT=213 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_estrategias`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_estrategias` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `estrategia` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_vocaestr_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='estrategias de aprendizaje' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_gramatica`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_gramatica` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `gramatica` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_vocagram_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='estructuras gramaticales' AUTO_INCREMENT=141 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_intenciones_de`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_intenciones_de` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `intencion` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ordenid` bigint(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_vocaintede_usu_ix` (`usuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='intenciones comunicativas' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_intenciones_en`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_intenciones_en` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `intencion` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ordenid` bigint(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_vocainteen_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='intenciones comunicativas' AUTO_INCREMENT=135 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_intenciones_es`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_intenciones_es` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `intencion` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ordenid` bigint(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_vocaintees_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='intenciones comunicativas' AUTO_INCREMENT=135 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_intenciones_fr`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_intenciones_fr` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `intencion` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ordenid` bigint(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_vocaintefr_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='intenciones comunicativas' AUTO_INCREMENT=135 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_intenciones_pl`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_intenciones_pl` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `intencion` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ordenid` bigint(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_vocaintepl_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='intenciones comunicativas' AUTO_INCREMENT=145 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_mis_estrategias`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_mis_estrategias` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) DEFAULT NULL,
  `estrategiaid` bigint(10) DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `tipo_palabra` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `palabra_id` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_vocamisestr_usuest_uix` (`usuarioid`,`estrategiaid`),
  KEY `mdl_vocamisestr_est_ix` (`estrategiaid`),
  KEY `mdl_vocamisestr_usu_ix` (`usuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='descripcion de los alumnos de las estrategias de aprendizaje' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_mis_gramaticas`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_mis_gramaticas` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) DEFAULT NULL,
  `gramaticaid` bigint(10) DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `tipo_palabra` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `palabra_id` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_vocamisgram_usupaltip_uix` (`usuarioid`,`palabra_id`,`tipo_palabra`),
  KEY `mdl_vocamisgram_gra_ix` (`gramaticaid`),
  KEY `mdl_vocamisgram_usu_ix` (`usuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='descripcion de los alumnos de las gramaticas' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_mis_intenciones`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_mis_intenciones` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) DEFAULT NULL,
  `intencionesid` bigint(10) DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `tipo_palabra` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `palabra_id` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_vocamisinte_usuint_uix` (`usuarioid`,`intencionesid`),
  KEY `mdl_vocamisinte_int_ix` (`intencionesid`),
  KEY `mdl_vocamisinte_usu_ix` (`usuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='descripcion de los alumnos de las intenciones comunicativas' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_mis_palabras`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_mis_palabras` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL,
  `sustantivoid` bigint(10) NOT NULL,
  `adjetivoid` bigint(10) NOT NULL DEFAULT '0',
  `verboid` bigint(10) NOT NULL DEFAULT '0',
  `otroid` bigint(10) NOT NULL DEFAULT '0',
  `campoid` bigint(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_vocamispala_susadjvero_uix` (`sustantivoid`,`adjetivoid`,`verboid`,`otroid`,`campoid`),
  KEY `mdl_vocamispala_usu_ix` (`usuarioid`),
  KEY `mdl_vocamispala_sus_ix` (`sustantivoid`),
  KEY `mdl_vocamispala_cam_ix` (`campoid`),
  KEY `mdl_vocamispala_adj_ix` (`adjetivoid`),
  KEY `mdl_vocamispala_ver_ix` (`verboid`),
  KEY `mdl_vocamispala_otr_ix` (`otroid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='palabras que guarda cada usuario' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_mis_tipologias`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_mis_tipologias` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) DEFAULT NULL,
  `tipoid` bigint(10) DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `tipo_palabra` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `palabra_id` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_vocamistipo_usutip_uix` (`usuarioid`,`tipoid`),
  KEY `mdl_vocamistipo_tip_ix` (`tipoid`),
  KEY `mdl_vocamistipo_usu_ix` (`usuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='descripcion de los alumnos de las tipologias textuales' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_otros`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_otros` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `palabra` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `significado` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observaciones` longtext COLLATE utf8_unicode_ci,
  `gramaticaid` bigint(10) DEFAULT NULL,
  `intencionid` bigint(10) DEFAULT NULL,
  `tipologiaid` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_vocaotro_gra_ix` (`gramaticaid`),
  KEY `mdl_vocaotro_int_ix` (`intencionid`),
  KEY `mdl_vocaotro_tip_ix` (`tipologiaid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='otro tipo de palabras' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_sustantivos`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_sustantivos` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `palabra` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `genero` tinyint(1) DEFAULT NULL,
  `plural` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `significado` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observaciones` longtext COLLATE utf8_unicode_ci,
  `gramaticaid` bigint(10) DEFAULT NULL,
  `intencionid` bigint(10) DEFAULT NULL,
  `tipologiaid` bigint(10) DEFAULT NULL,
  `ejemplo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_vocasust_gra_ix` (`gramaticaid`),
  KEY `mdl_vocasust_int_ix` (`intencionid`),
  KEY `mdl_vocasust_tip_ix` (`tipologiaid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='sustantivo' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_tipologias_de`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_tipologias_de` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `tipo` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_vocatipode_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tipologias textuales' AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_tipologias_en`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_tipologias_en` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `tipo` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_vocatipoen_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tipologias textuales' AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_tipologias_es`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_tipologias_es` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `tipo` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_vocatipoes_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tipologias textuales' AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_tipologias_fr`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_tipologias_fr` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `tipo` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_vocatipofr_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tipologias textuales' AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_tipologias_pl`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_tipologias_pl` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usuarioid` bigint(10) NOT NULL DEFAULT '0',
  `padre` bigint(10) NOT NULL DEFAULT '0',
  `tipo` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_vocatipopl_usu_ix` (`usuarioid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tipologias textuales' AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_vocabulario_verbos`
--

CREATE TABLE IF NOT EXISTS `mdl_vocabulario_verbos` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `infinitivo` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ter_pers_sing` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `preterito` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `participio` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `significado` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observaciones` longtext COLLATE utf8_unicode_ci,
  `gramaticaid` bigint(10) DEFAULT NULL,
  `intencionid` bigint(10) DEFAULT NULL,
  `tipologiaid` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_vocaverb_gra_ix` (`gramaticaid`),
  KEY `mdl_vocaverb_int_ix` (`intencionid`),
  KEY `mdl_vocaverb_tip_ix` (`tipologiaid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='verbos' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

