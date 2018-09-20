--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.6
-- Dumped by pg_dump version 10.4

-- Started on 2018-09-20 00:23:41

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 5 (class 2615 OID 190788)
-- Name: sesplan; Type: SCHEMA; Schema: -; Owner: sesplan_app
--

CREATE SCHEMA sesplan;


ALTER SCHEMA sesplan OWNER TO sesplan_app;

--
-- TOC entry 259 (class 1255 OID 190789)
-- Name: sp_execucao_orcamentaria(); Type: FUNCTION; Schema: sesplan; Owner: postgres
--

CREATE FUNCTION sesplan.sp_execucao_orcamentaria() RETURNS integer
    LANGUAGE plpgsql
    AS $_$
--DO $$
DECLARE 	
	v_dia INTEGER;
	v_mes INTEGER;
	v_ano INTEGER;
	v_ultimo_dia INTEGER;
	total INTEGER;
BEGIN
	Select INTO v_dia Extract('Day' From CURRENT_DATE) From CURRENT_DATE;
	Select INTO v_mes Extract('Month' From CURRENT_DATE) From CURRENT_DATE;	 
	Select INTO v_ano Extract('Year' From CURRENT_DATE) From CURRENT_DATE;	
	
	SELECT INTO v_ultimo_dia EXTRACT(DAY FROM ((v_ano||'/'||(v_mes + 1)||'/01'):: DATE - 1));
	
	IF v_dia = v_ultimo_dia THEN
		INSERT INTO SESPLAN.tab_siggo_sesplan_historico
		SELECT * FROM SESPLAN.tab_siggo_sesplan WHERE cast(inmes as integer) = v_mes;
		--RAISE NOTICE 'SIM';
		total := 1;
	ELSE
		--RAISE NOTICE '%', v_ultimo_dia;
		total := 0;
	END IF;
	RETURN total;
--END $$;
END;
$_$;


ALTER FUNCTION sesplan.sp_execucao_orcamentaria() OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 190790)
-- Name: cod_produto_etapa_seq; Type: SEQUENCE; Schema: sesplan; Owner: postgres
--

CREATE SEQUENCE sesplan.cod_produto_etapa_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE sesplan.cod_produto_etapa_seq OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 190792)
-- Name: cod_programa_trabalho_seq; Type: SEQUENCE; Schema: sesplan; Owner: postgres
--

CREATE SEQUENCE sesplan.cod_programa_trabalho_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE sesplan.cod_programa_trabalho_seq OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 190794)
-- Name: cod_sag_analise_seq; Type: SEQUENCE; Schema: sesplan; Owner: postgres
--

CREATE SEQUENCE sesplan.cod_sag_analise_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE sesplan.cod_sag_analise_seq OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 190796)
-- Name: cod_sag_seq; Type: SEQUENCE; Schema: sesplan; Owner: postgres
--

CREATE SEQUENCE sesplan.cod_sag_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE sesplan.cod_sag_seq OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 190798)
-- Name: cod_unidade_medida_seq; Type: SEQUENCE; Schema: sesplan; Owner: postgres
--

CREATE SEQUENCE sesplan.cod_unidade_medida_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE sesplan.cod_unidade_medida_seq OWNER TO postgres;

--
-- TOC entry 191 (class 1259 OID 190800)
-- Name: indicador; Type: SEQUENCE; Schema: sesplan; Owner: postgres
--

CREATE SEQUENCE sesplan.indicador
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE sesplan.indicador OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 190802)
-- Name: pas; Type: SEQUENCE; Schema: sesplan; Owner: postgres
--

CREATE SEQUENCE sesplan.pas
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE sesplan.pas OWNER TO postgres;

--
-- TOC entry 193 (class 1259 OID 190804)
-- Name: s_auditoria; Type: SEQUENCE; Schema: sesplan; Owner: sesplan_app
--

CREATE SEQUENCE sesplan.s_auditoria
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE sesplan.s_auditoria OWNER TO sesplan_app;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 194 (class 1259 OID 190806)
-- Name: tab_siggo_sesplan; Type: TABLE; Schema: sesplan; Owner: postgres
--

CREATE TABLE sesplan.tab_siggo_sesplan (
    cogestao character varying(255),
    inesfera character varying(255),
    couo character varying(255),
    cofuncao character varying(255),
    cosubfuncao character varying(255),
    coprograma character varying(255),
    coprojeto character varying(255),
    cosubtitulo character varying(255),
    cofonte character varying(255),
    fonte character varying(255),
    i_desc_subfuncao character varying(255),
    i_desc_origem character varying(255),
    desc_cod_fonte character varying(255),
    conatureza character varying(255),
    i_ano_exercicio character varying(255),
    inmes character varying(255),
    lei character varying(255),
    suplementacao character varying(255),
    cancelamento character varying(255),
    alteracao character varying(255),
    movimentacao character varying(255),
    movimentacao2 character varying(255),
    indisponivel character varying(255),
    empenhado character varying(255),
    disponivel character varying(255),
    liquidado character varying(255),
    bloqueado character varying(255),
    cota character varying(255),
    preempenhado character varying(255),
    contingenciado character varying(255),
    autorizado character varying(255),
    data_extracao character varying(255)
);


ALTER TABLE sesplan.tab_siggo_sesplan OWNER TO postgres;

--
-- TOC entry 195 (class 1259 OID 190812)
-- Name: tab_siggo_sesplan_historico; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tab_siggo_sesplan_historico (
    cogestao character varying(255),
    inesfera character varying(255),
    couo character varying(255),
    cofuncao character varying(255),
    cosubfuncao character varying(255),
    coprograma character varying(255),
    coprojeto character varying(255),
    cosubtitulo character varying(255),
    cofonte character varying(255),
    fonte character varying(255),
    i_desc_subfuncao character varying(255),
    i_desc_origem character varying(255),
    desc_cod_fonte character varying(255),
    conatureza character varying(255),
    i_ano_exercicio character varying(255),
    inmes character varying(255),
    lei character varying(255),
    suplementacao character varying(255),
    cancelamento character varying(255),
    alteracao character varying(255),
    movimentacao character varying(255),
    movimentacao2 character varying(255),
    indisponivel character varying(255),
    empenhado character varying(255),
    disponivel character varying(255),
    liquidado character varying(255),
    bloqueado character varying(255),
    cota character varying(255),
    preempenhado character varying(255),
    contingenciado character varying(255),
    autorizado character varying(255),
    data_extracao character varying(255),
    dt_inclusao timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE sesplan.tab_siggo_sesplan_historico OWNER TO sesplan_app;

--
-- TOC entry 196 (class 1259 OID 190819)
-- Name: tb_auditoria; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_auditoria (
    cod_auditoria integer NOT NULL,
    cod_acao_auditoria integer NOT NULL,
    dt_auditoria timestamp without time zone DEFAULT now() NOT NULL,
    cod_usuario integer NOT NULL,
    cod_orgao integer NOT NULL,
    txt_historico text,
    txt_sql text NOT NULL
);


ALTER TABLE sesplan.tb_auditoria OWNER TO sesplan_app;

--
-- TOC entry 197 (class 1259 OID 190826)
-- Name: tb_auditoria_acao; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_auditoria_acao (
    cod_acao_auditoria integer NOT NULL,
    txt_acao_auditoria character varying(2000) NOT NULL,
    cod_modulo_auditoria integer,
    cod_ativo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_auditoria_acao OWNER TO sesplan_app;

--
-- TOC entry 198 (class 1259 OID 190833)
-- Name: tb_auditoria_modulo; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_auditoria_modulo (
    cod_modulo_auditoria integer NOT NULL,
    txt_modulo_auditoria character varying(2000) NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_auditoria_modulo OWNER TO sesplan_app;

--
-- TOC entry 199 (class 1259 OID 190840)
-- Name: tb_cargo; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_cargo (
    cod_cargo integer NOT NULL,
    txt_cargo character varying(255) NOT NULL,
    txt_descricao character varying(255),
    cod_ativo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_cargo OWNER TO sesplan_app;

--
-- TOC entry 200 (class 1259 OID 190847)
-- Name: tb_diretriz; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_diretriz (
    cod_diretriz integer NOT NULL,
    cod_eixo integer NOT NULL,
    cod_perspectiva integer NOT NULL,
    txt_diretriz character varying(500) NOT NULL,
    txt_descricao character(200),
    cod_ativo integer DEFAULT 1 NOT NULL,
    codigo_diretriz character varying(50)
);


ALTER TABLE sesplan.tb_diretriz OWNER TO sesplan_app;

--
-- TOC entry 201 (class 1259 OID 190854)
-- Name: tb_eixo; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_eixo (
    cod_eixo integer NOT NULL,
    txt_eixo character varying(500) NOT NULL,
    txt_descricao character(200),
    cod_ativo integer DEFAULT 1 NOT NULL,
    codigo_eixo character varying(50)
);


ALTER TABLE sesplan.tb_eixo OWNER TO sesplan_app;

--
-- TOC entry 202 (class 1259 OID 190861)
-- Name: tb_hospital; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_hospital (
    cod_hospital integer NOT NULL,
    txt_hospital character varying(255) NOT NULL,
    txt_sigla_hospital character varying(255) NOT NULL,
    cod_regiao integer NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL,
    cod_tipo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_hospital OWNER TO sesplan_app;

--
-- TOC entry 203 (class 1259 OID 190869)
-- Name: tb_indicador; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_indicador (
    cod_chave integer NOT NULL,
    cod_objetivo integer NOT NULL,
    cod_objetivo_ppa integer NOT NULL,
    cod_indicador character varying(50) NOT NULL,
    cod_orgao integer,
    cod_meta character varying(50) NOT NULL,
    txt_descricao_meta text NOT NULL,
    dt_inclusao timestamp without time zone DEFAULT now() NOT NULL,
    cod_dados_mgi integer,
    txt_monitoramento character varying(255),
    txt_formula character varying(2000),
    cod_responsavel_tecnico integer,
    cod_regiao_tipo integer,
    cod_responsavel_tecnico_2 integer,
    cod_acumulativo integer DEFAULT 0 NOT NULL
);


ALTER TABLE sesplan.tb_indicador OWNER TO sesplan_app;

--
-- TOC entry 204 (class 1259 OID 190877)
-- Name: tb_indicador_analise; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_indicador_analise (
    cod_chave integer NOT NULL,
    cod_periodo integer NOT NULL,
    txt_analise text NOT NULL,
    cod_numerador character varying(50),
    cod_denominador character varying(50),
    cod_resultado character varying(50),
    cod_usuario integer,
    txt_encaminhamento text,
    dt_inclusao timestamp without time zone DEFAULT now() NOT NULL,
    cod_status integer,
    dt_extracao date,
    txt_variacao character varying(2000),
    txt_analise_2 text
);


ALTER TABLE sesplan.tb_indicador_analise OWNER TO sesplan_app;

--
-- TOC entry 205 (class 1259 OID 190884)
-- Name: tb_indicador_analise_historico; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_indicador_analise_historico (
    cod_chave integer,
    cod_periodo integer,
    txt_analise text,
    cod_numerador character varying(200),
    cod_denominador character varying(200),
    cod_resultado character varying(200),
    cod_usuario integer,
    txt_encaminhamento text,
    cod_status integer,
    dt_extracao date,
    txt_variacao character varying(2000),
    dt_inclusao timestamp without time zone DEFAULT now() NOT NULL,
    txt_analise_2 text
);


ALTER TABLE sesplan.tb_indicador_analise_historico OWNER TO sesplan_app;

--
-- TOC entry 206 (class 1259 OID 190891)
-- Name: tb_indicador_analise_regiao; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_indicador_analise_regiao (
    cod_chave integer NOT NULL,
    cod_periodo integer NOT NULL,
    cod_numerador character varying(50) NOT NULL,
    cod_denominador character varying(50) NOT NULL,
    cod_resultado character varying(50) NOT NULL,
    cod_usuario integer NOT NULL,
    dt_extracao date NOT NULL,
    dt_inclusao timestamp without time zone DEFAULT now() NOT NULL,
    cod_regiao_tipo integer,
    cod_ra integer,
    cod_urd integer,
    cod_hospital integer,
    cod_reg integer
);


ALTER TABLE sesplan.tb_indicador_analise_regiao OWNER TO sesplan_app;

--
-- TOC entry 207 (class 1259 OID 190895)
-- Name: tb_indicador_meta; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_indicador_meta (
    cod_indicador integer NOT NULL,
    campo_1 character varying(255),
    campo_2 character varying(255),
    campo_3 character varying(255),
    campo_4 character varying(255),
    campo_5 character varying(255),
    campo_6 character varying(255),
    campo_7 character varying(255),
    campo_8 character varying(255),
    campo_9 character varying(255),
    campo_10 character varying(255),
    campo_11 character varying(255),
    campo_12 character varying(255)
);


ALTER TABLE sesplan.tb_indicador_meta OWNER TO sesplan_app;

--
-- TOC entry 208 (class 1259 OID 190901)
-- Name: tb_indicador_periodo; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_indicador_periodo (
    cod_chave integer NOT NULL,
    dt_inicio date NOT NULL,
    dt_fim date NOT NULL,
    cod_usuario integer NOT NULL,
    dt_inclusao timestamp without time zone DEFAULT now() NOT NULL,
    dt_reabrir timestamp without time zone,
    cod_usuario_reabrir integer
);


ALTER TABLE sesplan.tb_indicador_periodo OWNER TO sesplan_app;

--
-- TOC entry 209 (class 1259 OID 190905)
-- Name: tb_mes; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_mes (
    cod_mes integer NOT NULL,
    txt_mes character varying(50) NOT NULL
);


ALTER TABLE sesplan.tb_mes OWNER TO sesplan_app;

--
-- TOC entry 210 (class 1259 OID 190908)
-- Name: tb_modulo; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_modulo (
    cod_modulo integer NOT NULL,
    txt_modulo character varying(100) NOT NULL,
    cod_exibir_consulta integer DEFAULT 0 NOT NULL,
    cod_ativo integer DEFAULT 1
);


ALTER TABLE sesplan.tb_modulo OWNER TO sesplan_app;

--
-- TOC entry 211 (class 1259 OID 190913)
-- Name: tb_modulo_sistema; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_modulo_sistema (
    cod_modulo_sistema integer NOT NULL,
    txt_modulo_sistema character varying(2000) NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL,
    cod_tipo integer DEFAULT 1 NOT NULL,
    cod_modulo_superior integer
);


ALTER TABLE sesplan.tb_modulo_sistema OWNER TO sesplan_app;

--
-- TOC entry 212 (class 1259 OID 190921)
-- Name: tb_modulo_sistema_acao; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_modulo_sistema_acao (
    cod_modulo_sistema_acao integer NOT NULL,
    txt_modulo_sistema_acao character varying(2000) NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_modulo_sistema_acao OWNER TO sesplan_app;

--
-- TOC entry 213 (class 1259 OID 190928)
-- Name: tb_objetivo; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_objetivo (
    cod_objetivo integer NOT NULL,
    cod_eixo integer NOT NULL,
    cod_perspectiva integer NOT NULL,
    cod_diretriz integer NOT NULL,
    txt_objetivo character varying(500) NOT NULL,
    txt_descricao character(200),
    cod_ativo integer DEFAULT 1 NOT NULL,
    codigo_objetivo character varying(50)
);


ALTER TABLE sesplan.tb_objetivo OWNER TO sesplan_app;

--
-- TOC entry 214 (class 1259 OID 190935)
-- Name: tb_objetivo_ppa; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_objetivo_ppa (
    cod_objetivo_ppa integer NOT NULL,
    cod_eixo integer NOT NULL,
    cod_perspectiva integer NOT NULL,
    cod_diretriz integer NOT NULL,
    cod_objetivo integer NOT NULL,
    txt_objetivo_ppa text NOT NULL,
    txt_descricao character(200),
    cod_ativo integer DEFAULT 1 NOT NULL,
    codigo_objetivo_ppa character varying(50)
);


ALTER TABLE sesplan.tb_objetivo_ppa OWNER TO sesplan_app;

--
-- TOC entry 215 (class 1259 OID 190942)
-- Name: tb_orgao; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_orgao (
    cod_orgao integer NOT NULL,
    txt_sigla character varying(200) NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL,
    cod_exibir_consulta integer DEFAULT 0 NOT NULL,
    txt_descricao character varying(500),
    txt_codigo character varying(50),
    cod_orgao_superior integer
);


ALTER TABLE sesplan.tb_orgao OWNER TO sesplan_app;

--
-- TOC entry 216 (class 1259 OID 190950)
-- Name: tb_pas; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_pas (
    cod_pas integer NOT NULL,
    cod_objetivo integer NOT NULL,
    cod_objetivo_ppa integer NOT NULL,
    txt_acao character varying(1000) NOT NULL,
    cod_orgao integer NOT NULL,
    cod_inicio_previsto integer NOT NULL,
    cod_fim_previsto integer NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL,
    cod_inicio_efetivo integer,
    cod_fim_efetivo integer,
    cod_resultado integer,
    dt_inclusao timestamp without time zone DEFAULT now() NOT NULL,
    cod_parceiro integer,
    cod_meta character varying(50) NOT NULL,
    codigo_acao character varying(2000),
    cod_controle integer,
    txt_medida character varying(50)
);


ALTER TABLE sesplan.tb_pas OWNER TO sesplan_app;

--
-- TOC entry 217 (class 1259 OID 190958)
-- Name: tb_pas_analise; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_pas_analise (
    cod_pas integer NOT NULL,
    cod_bimestre integer NOT NULL,
    txt_justificativa character varying(2000),
    cod_usuario integer NOT NULL,
    dt_inclusao timestamp without time zone DEFAULT now() NOT NULL,
    cod_migrado integer
);


ALTER TABLE sesplan.tb_pas_analise OWNER TO sesplan_app;

--
-- TOC entry 218 (class 1259 OID 190965)
-- Name: tb_pas_analise_historico; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_pas_analise_historico (
    cod_pas integer NOT NULL,
    cod_bimestre integer NOT NULL,
    txt_justificativa character varying(2000),
    cod_usuario integer NOT NULL,
    dt_inclusao timestamp without time zone NOT NULL,
    dt_inclusao_registro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE sesplan.tb_pas_analise_historico OWNER TO sesplan_app;

--
-- TOC entry 219 (class 1259 OID 190972)
-- Name: tb_pas_controle; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_pas_controle (
    cod_controle integer NOT NULL,
    txt_controle character varying(50) NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_pas_controle OWNER TO sesplan_app;

--
-- TOC entry 220 (class 1259 OID 190976)
-- Name: tb_pas_controle_historico; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_pas_controle_historico (
    cod_pas integer NOT NULL,
    cod_usuario integer NOT NULL,
    dt_inclusao timestamp without time zone DEFAULT now() NOT NULL,
    txt_justificativa character varying(20000),
    cod_usuario_autorizar integer,
    cod_autorizar integer,
    dt_autorizar timestamp without time zone
);


ALTER TABLE sesplan.tb_pas_controle_historico OWNER TO sesplan_app;

--
-- TOC entry 221 (class 1259 OID 190983)
-- Name: tb_pas_mes; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_pas_mes (
    cod_mes integer NOT NULL,
    txt_mes character varying(50) NOT NULL
);


ALTER TABLE sesplan.tb_pas_mes OWNER TO sesplan_app;

--
-- TOC entry 222 (class 1259 OID 190986)
-- Name: tb_pas_periodo; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_pas_periodo (
    cod_chave integer NOT NULL,
    dt_inicio date NOT NULL,
    dt_fim date NOT NULL,
    cod_usuario integer NOT NULL,
    dt_inclusao timestamp without time zone DEFAULT now() NOT NULL,
    dt_reabrir timestamp without time zone,
    cod_usuario_reabrir integer
);


ALTER TABLE sesplan.tb_pas_periodo OWNER TO sesplan_app;

--
-- TOC entry 223 (class 1259 OID 190990)
-- Name: tb_perfil; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_perfil (
    cod_perfil integer NOT NULL,
    txt_perfil character varying(255) NOT NULL,
    txt_descricao character varying(255),
    cod_ativo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_perfil OWNER TO sesplan_app;

--
-- TOC entry 224 (class 1259 OID 190997)
-- Name: tb_permissao_perfil; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_permissao_perfil (
    cod_permissao integer NOT NULL,
    cod_perfil integer NOT NULL
);


ALTER TABLE sesplan.tb_permissao_perfil OWNER TO sesplan_app;

--
-- TOC entry 225 (class 1259 OID 191000)
-- Name: tb_perspectiva; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_perspectiva (
    cod_perspectiva integer NOT NULL,
    cod_eixo integer NOT NULL,
    txt_perspectiva character varying(500) NOT NULL,
    txt_descricao character(200),
    cod_ativo integer NOT NULL,
    codigo_perspectiva character varying(50)
);


ALTER TABLE sesplan.tb_perspectiva OWNER TO sesplan_app;

--
-- TOC entry 226 (class 1259 OID 191006)
-- Name: tb_produto_etapa; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_produto_etapa (
    cod_produto_etapa integer DEFAULT nextval('sesplan.cod_produto_etapa_seq'::regclass) NOT NULL,
    txt_produto_etapa character varying(100),
    cod_ativo integer
);


ALTER TABLE sesplan.tb_produto_etapa OWNER TO sesplan_app;

--
-- TOC entry 227 (class 1259 OID 191010)
-- Name: tb_programa_trabalho; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_programa_trabalho (
    cod_programa_trabalho integer DEFAULT nextval('sesplan.cod_programa_trabalho_seq'::regclass) NOT NULL,
    nr_programa_trabalho character varying(50) NOT NULL,
    txt_programa_trabalho character varying(3000) NOT NULL,
    cod_eixo integer NOT NULL,
    cod_perspectiva integer NOT NULL,
    cod_diretriz integer NOT NULL,
    cod_objetivo integer NOT NULL,
    cod_objetivo_ppa integer NOT NULL,
    cod_ativo integer,
    txt_titulo_programa character varying(2000),
    cod_emenda integer
);


ALTER TABLE sesplan.tb_programa_trabalho OWNER TO sesplan_app;

--
-- TOC entry 228 (class 1259 OID 191017)
-- Name: tb_regiao; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_regiao (
    cod_regiao integer NOT NULL,
    txt_regiao character varying(2000) NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_regiao OWNER TO sesplan_app;

--
-- TOC entry 229 (class 1259 OID 191024)
-- Name: tb_regiao_administrativa; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_regiao_administrativa (
    cod_ra integer NOT NULL,
    txt_ra character varying(2000) NOT NULL,
    cod_regiao integer NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_regiao_administrativa OWNER TO sesplan_app;

--
-- TOC entry 230 (class 1259 OID 191031)
-- Name: tb_regiao_tipo; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_regiao_tipo (
    cod_regiao_tipo integer NOT NULL,
    txt_regiao_tipo character varying(255) NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_regiao_tipo OWNER TO sesplan_app;

--
-- TOC entry 231 (class 1259 OID 191035)
-- Name: tb_sag; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_sag (
    cod_sag integer DEFAULT nextval('sesplan.cod_sag_seq'::regclass) NOT NULL,
    cod_objetivo integer NOT NULL,
    cod_objetivo_ppa integer NOT NULL,
    cod_programa_trabalho integer NOT NULL,
    nr_etapa_trabalho integer,
    txt_etapa_trabalho character varying(8000),
    cod_produto_etapa integer,
    nr_meta integer,
    cod_orgao integer,
    cod_inicio_previsto integer,
    cod_fim_previsto integer,
    cod_modulo integer,
    cod_parceiro integer,
    cod_inicio_efetivo integer,
    cod_fim_efetivo integer,
    cod_resultado integer,
    cod_ativo integer DEFAULT 1 NOT NULL,
    dt_inclusao date DEFAULT ('now'::text)::date NOT NULL,
    dt_alteracao date,
    cod_unidade_medida integer,
    cod_obra integer DEFAULT 0 NOT NULL,
    cod_acumulativo integer DEFAULT 0 NOT NULL,
    nr_meta_1 integer,
    nr_meta_2 integer,
    nr_meta_3 integer,
    nr_meta_4 integer,
    nr_meta_5 integer,
    nr_meta_6 integer
);


ALTER TABLE sesplan.tb_sag OWNER TO sesplan_app;

--
-- TOC entry 232 (class 1259 OID 191046)
-- Name: tb_sag_analise; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_sag_analise (
    cod_sag integer NOT NULL,
    cod_bimestre integer NOT NULL,
    nr_mes_1 integer,
    nr_mes_2 integer,
    txt_analise character varying(2000),
    cod_situacao integer,
    cod_controle integer,
    cod_causa_desvio integer,
    cod_natureza_desvio integer,
    txt_analise_desvio character varying(2000),
    txt_realizado_1 character varying(2000),
    txt_realizado_2 character varying(2000),
    cod_percentual integer,
    txt_analise_obra character varying(2000),
    dt_inclusao timestamp without time zone DEFAULT now() NOT NULL,
    cod_usuario integer,
    cod_status integer,
    cod_migrado integer
);


ALTER TABLE sesplan.tb_sag_analise OWNER TO sesplan_app;

--
-- TOC entry 233 (class 1259 OID 191053)
-- Name: tb_sag_analise_historico; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_sag_analise_historico (
    cod_sag integer NOT NULL,
    cod_bimestre integer NOT NULL,
    nr_mes_1 integer,
    nr_mes_2 integer,
    txt_analise character varying(8000),
    cod_situacao integer,
    cod_controle integer,
    cod_causa_desvio integer,
    cod_natureza_desvio integer,
    txt_analise_desvio character varying(2000),
    txt_realizado_1 character varying(2000),
    txt_realizado_2 character varying(2000),
    cod_percentual integer,
    txt_analise_obra character varying(2000),
    dt_inclusao timestamp without time zone,
    cod_usuario integer,
    dt_inclusao_registro timestamp without time zone DEFAULT now() NOT NULL,
    cod_status integer
);


ALTER TABLE sesplan.tb_sag_analise_historico OWNER TO sesplan_app;

--
-- TOC entry 234 (class 1259 OID 191060)
-- Name: tb_sag_causa_desvio; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_sag_causa_desvio (
    cod_causa integer NOT NULL,
    txt_causa character varying(255) NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_sag_causa_desvio OWNER TO sesplan_app;

--
-- TOC entry 235 (class 1259 OID 191064)
-- Name: tb_sag_controle_analise; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_sag_controle_analise (
    cod_controle integer NOT NULL,
    txt_controle character varying(50) NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_sag_controle_analise OWNER TO sesplan_app;

--
-- TOC entry 236 (class 1259 OID 191068)
-- Name: tb_sag_natureza_desvio; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_sag_natureza_desvio (
    cod_natureza integer NOT NULL,
    txt_natureza character varying(255) NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_sag_natureza_desvio OWNER TO sesplan_app;

--
-- TOC entry 237 (class 1259 OID 191072)
-- Name: tb_sag_periodo; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_sag_periodo (
    cod_chave integer NOT NULL,
    dt_inicio date NOT NULL,
    dt_fim date NOT NULL,
    cod_usuario integer NOT NULL,
    dt_inclusao timestamp without time zone DEFAULT now() NOT NULL,
    dt_reabrir timestamp without time zone,
    cod_usuario_reabrir integer
);


ALTER TABLE sesplan.tb_sag_periodo OWNER TO sesplan_app;

--
-- TOC entry 238 (class 1259 OID 191076)
-- Name: tb_sag_situacao_analise; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_sag_situacao_analise (
    cod_situacao integer NOT NULL,
    txt_situacao character varying(50) NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL
);


ALTER TABLE sesplan.tb_sag_situacao_analise OWNER TO sesplan_app;

--
-- TOC entry 239 (class 1259 OID 191080)
-- Name: tb_sistema_modulo_acao; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_sistema_modulo_acao (
    cod_chave integer NOT NULL,
    cod_modulo_sistema integer NOT NULL,
    cod_modulo_sistema_acao integer NOT NULL
);


ALTER TABLE sesplan.tb_sistema_modulo_acao OWNER TO sesplan_app;

--
-- TOC entry 240 (class 1259 OID 191083)
-- Name: tb_status; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_status (
    cod_status integer NOT NULL,
    txt_status character varying(100) NOT NULL,
    txt_descricao character varying(255),
    cod_ativo integer DEFAULT 1 NOT NULL,
    txt_cor character varying(255)
);


ALTER TABLE sesplan.tb_status OWNER TO sesplan_app;

--
-- TOC entry 241 (class 1259 OID 191090)
-- Name: tb_status_modulo; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_status_modulo (
    cod_status integer NOT NULL,
    cod_modulo integer NOT NULL,
    cod_exibir_consulta integer DEFAULT 0 NOT NULL
);


ALTER TABLE sesplan.tb_status_modulo OWNER TO sesplan_app;

--
-- TOC entry 242 (class 1259 OID 191094)
-- Name: tb_unidade_medida; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_unidade_medida (
    cod_unidade_medida integer DEFAULT nextval('sesplan.cod_unidade_medida_seq'::regclass) NOT NULL,
    txt_unidade_medida character varying(50),
    cod_ativo integer
);


ALTER TABLE sesplan.tb_unidade_medida OWNER TO sesplan_app;

--
-- TOC entry 243 (class 1259 OID 191098)
-- Name: tb_urd; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_urd (
    cod_urd integer NOT NULL,
    txt_urd character varying(2000) NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL,
    txt_sigla character varying(255)
);


ALTER TABLE sesplan.tb_urd OWNER TO sesplan_app;

--
-- TOC entry 244 (class 1259 OID 191105)
-- Name: tb_usuario; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_usuario (
    cod_usuario integer NOT NULL,
    txt_usuario character varying(255) NOT NULL,
    txt_cpf character varying(11) NOT NULL,
    txt_email character varying(255) NOT NULL,
    cod_perfil integer NOT NULL,
    cod_ativo integer DEFAULT 1 NOT NULL,
    txt_login character varying(255),
    txt_matricula character varying(255),
    cod_cargo integer,
    cod_orgao integer
);


ALTER TABLE sesplan.tb_usuario OWNER TO sesplan_app;

--
-- TOC entry 245 (class 1259 OID 191112)
-- Name: tb_usuario_orgao; Type: TABLE; Schema: sesplan; Owner: sesplan_app
--

CREATE TABLE sesplan.tb_usuario_orgao (
    cod_usuario integer NOT NULL,
    cod_orgao integer NOT NULL
);


ALTER TABLE sesplan.tb_usuario_orgao OWNER TO sesplan_app;

--
-- TOC entry 246 (class 1259 OID 191115)
-- Name: teste; Type: SEQUENCE; Schema: sesplan; Owner: sesplan_app
--

CREATE SEQUENCE sesplan.teste
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE sesplan.teste OWNER TO sesplan_app;

--
-- TOC entry 2611 (class 0 OID 190806)
-- Dependencies: 194
-- Data for Name: tab_siggo_sesplan; Type: TABLE DATA; Schema: sesplan; Owner: postgres
--



--
-- TOC entry 2612 (class 0 OID 190812)
-- Dependencies: 195
-- Data for Name: tab_siggo_sesplan_historico; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2613 (class 0 OID 190819)
-- Dependencies: 196
-- Data for Name: tb_auditoria; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2614 (class 0 OID 190826)
-- Dependencies: 197
-- Data for Name: tb_auditoria_acao; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--

INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (1, 'AUTENTICAR USUÁRIO', 9, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (2, 'LISTAR ÁREA RESPONSÁVEL', 1, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (3, 'LISTAR TABELAS DE APOIO', 10, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (4, 'INCLUIR ÁREA RESPONSÁVEL', 1, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (5, 'ALTERAR ÁREA RESPONSÁVEL', 1, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (6, 'EXCLUIR ÁREA RESPONSÁVEL', 1, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (7, 'LISTAR CARGOS', 2, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (8, 'INCLUIR CARGO', 2, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (9, 'ALTERAR CARGO', 2, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (10, 'EXCLUIR CARGO', 2, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (11, 'LISTAR INSTRUMENTOS DE PLANEJAMENTO', 3, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (12, 'INCLUIR INSTRUMENTOS DE PLANEJAMENTO', 3, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (13, 'ALTERAR INSTRUMENTOS DE PLANEJAMENTO', 3, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (14, 'EXCLUIR INSTRUMENTOS DE PLANEJAMENTO', 3, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (15, 'LISTAR SITUAÇÕES DOS INSTRUMENTOS DE PLANEJAMENTO', 3, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (16, 'INCLUIR SITUAÇÕES DOS INSTRUMENTOS DE PLANEJAMENTO', 3, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (17, 'ALTERAR SITUAÇÕES DOS INSTRUMENTOS DE PLANEJAMENTO', 3, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (18, 'EXCLUIR SITUAÇÕES DOS INSTRUMENTOS DE PLANEJAMENTO', 3, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (19, 'LISTAR PRODUTO DA ETAPA', 4, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (20, 'INCLUIR PRODUTO DA ETAPA', 4, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (21, 'ALTERAR PRODUTO DA ETAPA', 4, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (22, 'EXCLUIR PRODUTO DA ETAPA', 4, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (23, 'LISTAR UNIDADES DE MEDIDA', 5, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (24, 'INCLUIR UNIDADES DE MEDIDA', 5, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (25, 'ALTERAR UNIDADES DE MEDIDA', 5, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (26, 'EXCLUIR UNIDADES DE MEDIDA', 5, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (27, 'LISTAR SITUAÇÕES', 7, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (28, 'INCLUIR SITUAÇÕES', 7, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (29, 'ALTERAR SITUAÇÕES', 7, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (30, 'EXCLUIR SITUAÇÕES', 7, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (31, 'LISTAR PERFIS DE USUÁRIOS', 6, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (32, 'INCLUIR PERFIS DE USUÁRIOS', 6, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (33, 'ALTERAR PERFIS DE USUÁRIOS', 6, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (34, 'EXCLUIR PERFIS DE USUÁRIOS', 6, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (35, 'LISTAR USUÁRIOS', 6, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (36, 'INCLUIR USUÁRIOS', 6, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (37, 'VINCULAR UNIDADES DE USUÁRIOS', 6, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (38, 'ALTERAR USUÁRIOS', 6, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (39, 'EXCLUIR UNIDADES DE USUÁRIOS', 6, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (40, 'EXCLUIR USUÁRIOS', 6, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (41, 'ACESSAR RELATÓRIO DE AUDITORIA', 11, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (44, 'ALTERAR PROGRAMA DE TRABALHO', 12, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (43, 'INCLUIR PROGRAMA DE TRABALHO', 12, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (45, 'EXCLUIR PROGRAMA DE TRABALHO', 12, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (42, 'ACESSAR PROGRAMAS DE TRABALHO', 12, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (46, 'LISTAR EIXOS', 13, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (47, 'INCLUIR EIXO', 13, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (48, 'ALTERAR EIXO', 13, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (49, 'EXCLUIR EIXO', 13, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (50, 'LISTAR PERSPECTIVAS', 14, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (51, 'INCLUIR PERSPECTIVA', 14, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (52, 'ALTERAR PERSPECTIVA', 14, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (53, 'EXCLUIR PERSPECTIVA', 14, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (54, 'LISTAR DIRETRIZES', 15, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (55, 'INCLUIR DIRETRIZ', 15, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (56, 'ALTERAR DIRETRIZ', 15, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (57, 'EXCLUIR DIRETRIZ', 15, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (58, 'LISTAR OBJETIVOS', 16, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (59, 'INCLUIR OBJETIVO', 16, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (60, 'ALTERAR OBJETIVO', 16, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (61, 'EXCLUIR OBJETIVO', 16, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (62, 'LISTAR OBJETIVOS PPA', 17, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (63, 'INCLUIR OBJETIVO PPA', 17, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (64, 'ALTERAR OBJETIVO PPA', 17, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (65, 'EXCLUIR OBJETIVO PPA', 17, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (66, 'LISTAR PERÍODO DE ATUALIZAÇÃO DE INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (67, 'INCLUIR PERÍODO DE ATUALIZAÇÃO DE INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (68, 'ALTERAR PERÍODO DE ATUALIZAÇÃO DE INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (69, 'EXCLUIR PERÍODO DE ATUALIZAÇÃO DE INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (70, 'ENCERRAR PERÍODO DE ATUALIZAÇÃO DE INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (71, 'REABRIR PERÍODO DE ATUALIZAÇÃO DE INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (72, 'LISTAR INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (73, 'DETALHAR INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (75, 'ALTERAR INDICADOR', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (74, 'INCLUIR INDICADOR', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (76, 'EXCLUIR INDICADOR', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (77, 'HISTÓRICO DE ANÁLISE DE INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (78, 'FICHA TÉCNICA DE INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (79, 'ANÁLISE DE INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (80, 'INCLUIR ANÁLISE DE INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (81, 'ALTERAR ANÁLISE DE INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (82, 'INCLUIR HISTÓRICO DE ANÁLISE DE INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (83, 'EXCLUIR ANÁLISE DE INDICADORES', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (84, 'LISTAR RÉGUAS', 19, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (85, 'LISTAR PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (86, 'INCLUIR PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (87, 'ALTERAR PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (88, 'EXCLUIR PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (89, 'INCLUIR CONSIDERAÇÃO PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (90, 'ALTERAR CONSIDERAÇÃO PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (91, 'EXCLUIR CONSIDERAÇÃO PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (92, 'LISTAR PERÍODO DE ATUALIZAÇÃO PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (93, 'INCLUIR PERÍODO DE ATUALIZAÇÃO PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (94, 'ALTERAR PERÍODO DE ATUALIZAÇÃO PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (95, 'EXCLUIR PERÍODO DE ATUALIZAÇÃO PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (96, 'ENCERRAR PERÍODO DE ATUALIZAÇÃO PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (97, 'REABRIR PERÍODO DE ATUALIZAÇÃO PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (98, 'FINALIZAR CADASTRO PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (99, 'INCLUIR CONTROLE PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (100, 'LISTAR CONTROLE PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (101, 'ALTERAR CONTROLE PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (102, 'ANÁLISE PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (103, 'INCLUIR ANÁLISE PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (104, 'ALTERAR ANÁLISE PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (105, 'INCLUIR HISTÓRICO DE ANÁLISE PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (106, 'HISTÓRICO DE ANÁLISE PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (107, 'EXCLUIR CONTROLE PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (108, 'EXCLUIR ANÁLISE PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (109, 'INCLUIR SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (110, 'ALTERAR SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (111, 'LISTAR SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (112, 'EXCLUIR SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (113, 'INCLUIR ANÁLISE SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (114, 'ALTERAR ANÁLISE SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (115, 'EXCLUIR ANÁLISE SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (116, 'ANÁLISE SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (117, 'LIMPAR DADOS PAS', 20, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (118, 'PERFIS DE USUÁRIOS PERMISSÃO DE ACESSO', 6, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (119, 'LISTAR PERMISSÕES DE PERFIS DE USUÁRIOS', 6, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (120, 'LISTAR PERÍODO DE ATUALIZAÇÃO SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (121, 'INCLUIR PERÍODO DE ATUALIZAÇÃO SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (122, 'ALTERAR PERÍODO DE ATUALIZAÇÃO SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (123, 'EXCLUIR PERÍODO DE ATUALIZAÇÃO SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (124, 'ENCERRAR PERÍODO DE ATUALIZAÇÃO SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (125, 'REABRIR PERÍODO DE ATUALIZAÇÃO SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (126, 'INCLUIR HISTÓRICO DE ANÁLISE SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (127, 'HISTÓRICO DE ANÁLISE SAG', 21, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (128, 'INCLUIR HISTÓRICO DE ANÁLISE DE INDICADORES POR REGIÃO', 18, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (129, 'LISTAR CICLO PLANEJAMENTO', 22, 1);
INSERT INTO sesplan.tb_auditoria_acao (cod_acao_auditoria, txt_acao_auditoria, cod_modulo_auditoria, cod_ativo) VALUES (130, 'LISTAR EXECUÇÃO ORÇAMENTÁRIA', 23, 1);


--
-- TOC entry 2615 (class 0 OID 190833)
-- Dependencies: 198
-- Data for Name: tb_auditoria_modulo; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--

INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (1, 'Área Responsável', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (2, 'Cargos', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (3, 'Instrumento de Planejamento', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (4, 'Produto da Etapa', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (5, 'Unidade de Medida', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (6, 'Perfis de Usuários', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (7, 'Situações', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (8, 'Usuários', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (9, 'Autenticação', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (10, 'Tabelas de Apoio', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (11, 'Relatórios', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (12, 'Programa de Trabalho', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (13, 'Eixo', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (14, 'Perspectiva', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (15, 'Diretriz', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (16, 'Objetivo', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (17, 'Objetivo PPA', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (18, 'Indicadores', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (19, 'Régua', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (20, 'PAS', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (21, 'SAG', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (22, 'Ciclo Planejamento', 1);
INSERT INTO sesplan.tb_auditoria_modulo (cod_modulo_auditoria, txt_modulo_auditoria, cod_ativo) VALUES (23, 'Execução Orçamentária', 1);


--
-- TOC entry 2616 (class 0 OID 190840)
-- Dependencies: 199
-- Data for Name: tb_cargo; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2617 (class 0 OID 190847)
-- Dependencies: 200
-- Data for Name: tb_diretriz; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2618 (class 0 OID 190854)
-- Dependencies: 201
-- Data for Name: tb_eixo; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2619 (class 0 OID 190861)
-- Dependencies: 202
-- Data for Name: tb_hospital; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2620 (class 0 OID 190869)
-- Dependencies: 203
-- Data for Name: tb_indicador; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2621 (class 0 OID 190877)
-- Dependencies: 204
-- Data for Name: tb_indicador_analise; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2622 (class 0 OID 190884)
-- Dependencies: 205
-- Data for Name: tb_indicador_analise_historico; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2623 (class 0 OID 190891)
-- Dependencies: 206
-- Data for Name: tb_indicador_analise_regiao; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2624 (class 0 OID 190895)
-- Dependencies: 207
-- Data for Name: tb_indicador_meta; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2625 (class 0 OID 190901)
-- Dependencies: 208
-- Data for Name: tb_indicador_periodo; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2626 (class 0 OID 190905)
-- Dependencies: 209
-- Data for Name: tb_mes; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--

INSERT INTO sesplan.tb_mes (cod_mes, txt_mes) VALUES (1, 'Janeiro');
INSERT INTO sesplan.tb_mes (cod_mes, txt_mes) VALUES (2, 'Fevereiro');
INSERT INTO sesplan.tb_mes (cod_mes, txt_mes) VALUES (3, 'Março');
INSERT INTO sesplan.tb_mes (cod_mes, txt_mes) VALUES (4, 'Abril');
INSERT INTO sesplan.tb_mes (cod_mes, txt_mes) VALUES (5, 'Maio');
INSERT INTO sesplan.tb_mes (cod_mes, txt_mes) VALUES (6, 'Junho');
INSERT INTO sesplan.tb_mes (cod_mes, txt_mes) VALUES (7, 'Julho');
INSERT INTO sesplan.tb_mes (cod_mes, txt_mes) VALUES (8, 'Agosto');
INSERT INTO sesplan.tb_mes (cod_mes, txt_mes) VALUES (9, 'Setembro');
INSERT INTO sesplan.tb_mes (cod_mes, txt_mes) VALUES (10, 'Outubro');
INSERT INTO sesplan.tb_mes (cod_mes, txt_mes) VALUES (11, 'Novembro');
INSERT INTO sesplan.tb_mes (cod_mes, txt_mes) VALUES (12, 'Dezembro');


--
-- TOC entry 2627 (class 0 OID 190908)
-- Dependencies: 210
-- Data for Name: tb_modulo; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2628 (class 0 OID 190913)
-- Dependencies: 211
-- Data for Name: tb_modulo_sistema; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--

INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (1, 'Eixo', 1, 1, NULL);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (2, 'Perspectiva', 1, 1, NULL);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (3, 'Objetivo', 1, 1, NULL);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (4, 'Objetivo PPA', 1, 1, NULL);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (5, 'Programa de Trabalho', 1, 1, NULL);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (6, 'Tabelas de Apoio', 1, 2, NULL);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (7, 'Relatórios', 1, 2, NULL);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (8, 'Régua', 1, 1, NULL);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (9, 'Monitoramento', 1, 2, NULL);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (10, 'Área Responsável', 1, 1, 6);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (11, 'Cargos', 1, 1, 6);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (12, 'Instrumento de Planejamento', 1, 1, 6);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (13, 'Produto da Etapa', 1, 1, 6);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (14, 'Unidade de Medida', 1, 1, 6);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (15, 'Perfis de Usuários', 1, 1, 6);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (16, 'Situações', 1, 1, 6);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (17, 'Usuários', 1, 1, 6);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (18, 'Auditoria', 1, 1, 7);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (19, 'Execução Orçamentária', 1, 1, 9);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (20, 'Indicador', 1, 1, 9);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (21, 'PAS', 1, 1, 9);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (22, 'SAG', 1, 1, 9);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (24, 'Ciclo Planejamento', 1, 1, NULL);
INSERT INTO sesplan.tb_modulo_sistema (cod_modulo_sistema, txt_modulo_sistema, cod_ativo, cod_tipo, cod_modulo_superior) VALUES (23, 'Diretriz', 1, 1, NULL);


--
-- TOC entry 2629 (class 0 OID 190921)
-- Dependencies: 212
-- Data for Name: tb_modulo_sistema_acao; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--

INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (1, 'Incluir', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (2, 'Editar', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (3, 'Excluir', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (4, 'Acessar', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (5, 'Situações', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (6, 'Permissões', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (7, 'Unidades', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (8, 'Histórico', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (9, 'Ficha', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (10, 'Análise', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (11, 'Período de Atualização', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (12, 'Controle', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (13, 'Salvar', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (14, 'Limpar', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (15, 'Listagem', 1);
INSERT INTO sesplan.tb_modulo_sistema_acao (cod_modulo_sistema_acao, txt_modulo_sistema_acao, cod_ativo) VALUES (16, 'Visualizar Análise', 1);


--
-- TOC entry 2630 (class 0 OID 190928)
-- Dependencies: 213
-- Data for Name: tb_objetivo; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2631 (class 0 OID 190935)
-- Dependencies: 214
-- Data for Name: tb_objetivo_ppa; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2632 (class 0 OID 190942)
-- Dependencies: 215
-- Data for Name: tb_orgao; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2633 (class 0 OID 190950)
-- Dependencies: 216
-- Data for Name: tb_pas; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2634 (class 0 OID 190958)
-- Dependencies: 217
-- Data for Name: tb_pas_analise; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2635 (class 0 OID 190965)
-- Dependencies: 218
-- Data for Name: tb_pas_analise_historico; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2636 (class 0 OID 190972)
-- Dependencies: 219
-- Data for Name: tb_pas_controle; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2637 (class 0 OID 190976)
-- Dependencies: 220
-- Data for Name: tb_pas_controle_historico; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2638 (class 0 OID 190983)
-- Dependencies: 221
-- Data for Name: tb_pas_mes; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--

INSERT INTO sesplan.tb_pas_mes (cod_mes, txt_mes) VALUES (1, 'Janeiro/Fevereiro');
INSERT INTO sesplan.tb_pas_mes (cod_mes, txt_mes) VALUES (2, 'Março/Abril');
INSERT INTO sesplan.tb_pas_mes (cod_mes, txt_mes) VALUES (3, 'Maio/Junho');
INSERT INTO sesplan.tb_pas_mes (cod_mes, txt_mes) VALUES (4, 'Julho/Agosto');
INSERT INTO sesplan.tb_pas_mes (cod_mes, txt_mes) VALUES (5, 'Setembro/Outubro');
INSERT INTO sesplan.tb_pas_mes (cod_mes, txt_mes) VALUES (6, 'Novembro/Dezembro');


--
-- TOC entry 2639 (class 0 OID 190986)
-- Dependencies: 222
-- Data for Name: tb_pas_periodo; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2640 (class 0 OID 190990)
-- Dependencies: 223
-- Data for Name: tb_perfil; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--

INSERT INTO sesplan.tb_perfil (cod_perfil, txt_perfil, txt_descricao, cod_ativo) VALUES (1, 'ADMINISTRADOR', 'Responsável pela administração do sistema', 1);


--
-- TOC entry 2641 (class 0 OID 190997)
-- Dependencies: 224
-- Data for Name: tb_permissao_perfil; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2642 (class 0 OID 191000)
-- Dependencies: 225
-- Data for Name: tb_perspectiva; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2643 (class 0 OID 191006)
-- Dependencies: 226
-- Data for Name: tb_produto_etapa; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2644 (class 0 OID 191010)
-- Dependencies: 227
-- Data for Name: tb_programa_trabalho; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2645 (class 0 OID 191017)
-- Dependencies: 228
-- Data for Name: tb_regiao; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2646 (class 0 OID 191024)
-- Dependencies: 229
-- Data for Name: tb_regiao_administrativa; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2647 (class 0 OID 191031)
-- Dependencies: 230
-- Data for Name: tb_regiao_tipo; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2648 (class 0 OID 191035)
-- Dependencies: 231
-- Data for Name: tb_sag; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2649 (class 0 OID 191046)
-- Dependencies: 232
-- Data for Name: tb_sag_analise; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2650 (class 0 OID 191053)
-- Dependencies: 233
-- Data for Name: tb_sag_analise_historico; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2651 (class 0 OID 191060)
-- Dependencies: 234
-- Data for Name: tb_sag_causa_desvio; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2652 (class 0 OID 191064)
-- Dependencies: 235
-- Data for Name: tb_sag_controle_analise; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2653 (class 0 OID 191068)
-- Dependencies: 236
-- Data for Name: tb_sag_natureza_desvio; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2654 (class 0 OID 191072)
-- Dependencies: 237
-- Data for Name: tb_sag_periodo; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2655 (class 0 OID 191076)
-- Dependencies: 238
-- Data for Name: tb_sag_situacao_analise; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2656 (class 0 OID 191080)
-- Dependencies: 239
-- Data for Name: tb_sistema_modulo_acao; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--

INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (1, 1, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (2, 1, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (3, 1, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (4, 1, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (5, 2, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (6, 2, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (7, 2, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (8, 2, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (9, 3, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (10, 3, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (11, 3, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (12, 3, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (13, 4, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (14, 4, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (15, 4, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (16, 4, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (17, 5, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (18, 5, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (19, 5, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (20, 5, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (21, 8, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (22, 9, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (23, 6, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (24, 7, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (25, 10, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (26, 10, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (27, 10, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (28, 10, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (29, 11, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (30, 11, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (31, 11, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (32, 11, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (33, 12, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (34, 12, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (35, 12, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (36, 12, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (37, 12, 5);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (38, 13, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (39, 13, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (40, 13, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (41, 13, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (42, 14, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (43, 14, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (44, 14, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (45, 14, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (46, 15, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (47, 15, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (48, 15, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (49, 15, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (50, 15, 6);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (51, 16, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (52, 16, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (53, 17, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (54, 17, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (55, 17, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (56, 17, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (57, 17, 7);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (58, 18, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (59, 19, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (60, 20, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (61, 20, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (62, 20, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (63, 20, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (64, 20, 8);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (65, 20, 9);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (66, 20, 10);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (67, 21, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (68, 21, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (69, 21, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (70, 21, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (71, 21, 11);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (72, 21, 12);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (74, 21, 13);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (75, 21, 14);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (73, 21, 8);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (76, 22, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (77, 22, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (78, 22, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (79, 22, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (80, 22, 11);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (81, 22, 10);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (82, 22, 8);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (83, 21, 10);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (84, 23, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (85, 23, 1);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (86, 23, 2);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (87, 23, 3);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (88, 16, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (90, 22, 15);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (89, 21, 15);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (91, 20, 11);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (92, 24, 4);
INSERT INTO sesplan.tb_sistema_modulo_acao (cod_chave, cod_modulo_sistema, cod_modulo_sistema_acao) VALUES (93, 20, 16);


--
-- TOC entry 2657 (class 0 OID 191083)
-- Dependencies: 240
-- Data for Name: tb_status; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2658 (class 0 OID 191090)
-- Dependencies: 241
-- Data for Name: tb_status_modulo; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2659 (class 0 OID 191094)
-- Dependencies: 242
-- Data for Name: tb_unidade_medida; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2660 (class 0 OID 191098)
-- Dependencies: 243
-- Data for Name: tb_urd; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2661 (class 0 OID 191105)
-- Dependencies: 244
-- Data for Name: tb_usuario; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2662 (class 0 OID 191112)
-- Dependencies: 245
-- Data for Name: tb_usuario_orgao; Type: TABLE DATA; Schema: sesplan; Owner: sesplan_app
--



--
-- TOC entry 2706 (class 0 OID 0)
-- Dependencies: 186
-- Name: cod_produto_etapa_seq; Type: SEQUENCE SET; Schema: sesplan; Owner: postgres
--

SELECT pg_catalog.setval('sesplan.cod_produto_etapa_seq', 20, true);


--
-- TOC entry 2707 (class 0 OID 0)
-- Dependencies: 187
-- Name: cod_programa_trabalho_seq; Type: SEQUENCE SET; Schema: sesplan; Owner: postgres
--

SELECT pg_catalog.setval('sesplan.cod_programa_trabalho_seq', 157, true);


--
-- TOC entry 2708 (class 0 OID 0)
-- Dependencies: 188
-- Name: cod_sag_analise_seq; Type: SEQUENCE SET; Schema: sesplan; Owner: postgres
--

SELECT pg_catalog.setval('sesplan.cod_sag_analise_seq', 5, true);


--
-- TOC entry 2709 (class 0 OID 0)
-- Dependencies: 189
-- Name: cod_sag_seq; Type: SEQUENCE SET; Schema: sesplan; Owner: postgres
--

SELECT pg_catalog.setval('sesplan.cod_sag_seq', 229, true);


--
-- TOC entry 2710 (class 0 OID 0)
-- Dependencies: 190
-- Name: cod_unidade_medida_seq; Type: SEQUENCE SET; Schema: sesplan; Owner: postgres
--

SELECT pg_catalog.setval('sesplan.cod_unidade_medida_seq', 6, true);


--
-- TOC entry 2711 (class 0 OID 0)
-- Dependencies: 191
-- Name: indicador; Type: SEQUENCE SET; Schema: sesplan; Owner: postgres
--

SELECT pg_catalog.setval('sesplan.indicador', 172, true);


--
-- TOC entry 2712 (class 0 OID 0)
-- Dependencies: 192
-- Name: pas; Type: SEQUENCE SET; Schema: sesplan; Owner: postgres
--

SELECT pg_catalog.setval('sesplan.pas', 441, true);


--
-- TOC entry 2713 (class 0 OID 0)
-- Dependencies: 193
-- Name: s_auditoria; Type: SEQUENCE SET; Schema: sesplan; Owner: sesplan_app
--

SELECT pg_catalog.setval('sesplan.s_auditoria', 46349, true);


--
-- TOC entry 2714 (class 0 OID 0)
-- Dependencies: 246
-- Name: teste; Type: SEQUENCE SET; Schema: sesplan; Owner: sesplan_app
--

SELECT pg_catalog.setval('sesplan.teste', 1, false);


--
-- TOC entry 2317 (class 2606 OID 191119)
-- Name: tb_auditoria_acao tb_auditoria_acao_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_auditoria_acao
    ADD CONSTRAINT tb_auditoria_acao_pkey PRIMARY KEY (cod_acao_auditoria);


--
-- TOC entry 2319 (class 2606 OID 191121)
-- Name: tb_auditoria_modulo tb_auditoria_modulo_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_auditoria_modulo
    ADD CONSTRAINT tb_auditoria_modulo_pkey PRIMARY KEY (cod_modulo_auditoria);


--
-- TOC entry 2315 (class 2606 OID 191123)
-- Name: tb_auditoria tb_auditoria_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_auditoria
    ADD CONSTRAINT tb_auditoria_pkey PRIMARY KEY (cod_auditoria);


--
-- TOC entry 2321 (class 2606 OID 191125)
-- Name: tb_cargo tb_cargo_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_cargo
    ADD CONSTRAINT tb_cargo_pkey PRIMARY KEY (cod_cargo);


--
-- TOC entry 2324 (class 2606 OID 191127)
-- Name: tb_diretriz tb_diretriz_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_diretriz
    ADD CONSTRAINT tb_diretriz_pkey PRIMARY KEY (cod_diretriz);


--
-- TOC entry 2327 (class 2606 OID 191129)
-- Name: tb_eixo tb_eixo_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_eixo
    ADD CONSTRAINT tb_eixo_pkey PRIMARY KEY (cod_eixo);


--
-- TOC entry 2330 (class 2606 OID 191131)
-- Name: tb_hospital tb_hospital_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_hospital
    ADD CONSTRAINT tb_hospital_pkey PRIMARY KEY (cod_hospital);


--
-- TOC entry 2334 (class 2606 OID 191133)
-- Name: tb_indicador_analise tb_indicador_analise_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador_analise
    ADD CONSTRAINT tb_indicador_analise_pkey PRIMARY KEY (cod_chave, cod_periodo);


--
-- TOC entry 2336 (class 2606 OID 191135)
-- Name: tb_indicador_meta tb_indicador_meta_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador_meta
    ADD CONSTRAINT tb_indicador_meta_pkey PRIMARY KEY (cod_indicador);


--
-- TOC entry 2338 (class 2606 OID 191137)
-- Name: tb_indicador_periodo tb_indicador_periodo_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador_periodo
    ADD CONSTRAINT tb_indicador_periodo_pkey PRIMARY KEY (cod_chave);


--
-- TOC entry 2332 (class 2606 OID 191139)
-- Name: tb_indicador tb_indicador_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador
    ADD CONSTRAINT tb_indicador_pkey PRIMARY KEY (cod_chave);


--
-- TOC entry 2340 (class 2606 OID 191141)
-- Name: tb_mes tb_mes_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_mes
    ADD CONSTRAINT tb_mes_pkey PRIMARY KEY (cod_mes);


--
-- TOC entry 2342 (class 2606 OID 191143)
-- Name: tb_modulo tb_modulo_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_modulo
    ADD CONSTRAINT tb_modulo_pkey PRIMARY KEY (cod_modulo);


--
-- TOC entry 2346 (class 2606 OID 191145)
-- Name: tb_modulo_sistema_acao tb_modulo_sistema_acao_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_modulo_sistema_acao
    ADD CONSTRAINT tb_modulo_sistema_acao_pkey PRIMARY KEY (cod_modulo_sistema_acao);


--
-- TOC entry 2344 (class 2606 OID 191147)
-- Name: tb_modulo_sistema tb_modulo_sistema_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_modulo_sistema
    ADD CONSTRAINT tb_modulo_sistema_pkey PRIMARY KEY (cod_modulo_sistema);


--
-- TOC entry 2348 (class 2606 OID 191149)
-- Name: tb_objetivo tb_objetivo_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_objetivo
    ADD CONSTRAINT tb_objetivo_pkey PRIMARY KEY (cod_objetivo);


--
-- TOC entry 2351 (class 2606 OID 191151)
-- Name: tb_objetivo_ppa tb_objetivo_ppa_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_objetivo_ppa
    ADD CONSTRAINT tb_objetivo_ppa_pkey PRIMARY KEY (cod_objetivo_ppa);


--
-- TOC entry 2354 (class 2606 OID 191153)
-- Name: tb_orgao tb_orgao_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_orgao
    ADD CONSTRAINT tb_orgao_pkey PRIMARY KEY (cod_orgao);


--
-- TOC entry 2359 (class 2606 OID 191155)
-- Name: tb_pas_analise tb_pas_analise_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas_analise
    ADD CONSTRAINT tb_pas_analise_pkey PRIMARY KEY (cod_pas, cod_bimestre);


--
-- TOC entry 2363 (class 2606 OID 191157)
-- Name: tb_pas_controle_historico tb_pas_controle_historico_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas_controle_historico
    ADD CONSTRAINT tb_pas_controle_historico_pkey PRIMARY KEY (cod_pas);


--
-- TOC entry 2361 (class 2606 OID 191159)
-- Name: tb_pas_controle tb_pas_controle_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas_controle
    ADD CONSTRAINT tb_pas_controle_pkey PRIMARY KEY (cod_controle);


--
-- TOC entry 2365 (class 2606 OID 191161)
-- Name: tb_pas_mes tb_pas_mes_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas_mes
    ADD CONSTRAINT tb_pas_mes_pkey PRIMARY KEY (cod_mes);


--
-- TOC entry 2367 (class 2606 OID 191163)
-- Name: tb_pas_periodo tb_pas_periodo_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas_periodo
    ADD CONSTRAINT tb_pas_periodo_pkey PRIMARY KEY (cod_chave);


--
-- TOC entry 2357 (class 2606 OID 191165)
-- Name: tb_pas tb_pas_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas
    ADD CONSTRAINT tb_pas_pkey PRIMARY KEY (cod_pas);


--
-- TOC entry 2369 (class 2606 OID 191167)
-- Name: tb_perfil tb_perfil_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_perfil
    ADD CONSTRAINT tb_perfil_pkey PRIMARY KEY (cod_perfil);


--
-- TOC entry 2372 (class 2606 OID 191169)
-- Name: tb_permissao_perfil tb_permissao_perfil_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_permissao_perfil
    ADD CONSTRAINT tb_permissao_perfil_pkey PRIMARY KEY (cod_permissao, cod_perfil);


--
-- TOC entry 2374 (class 2606 OID 191171)
-- Name: tb_perspectiva tb_perspectiva_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_perspectiva
    ADD CONSTRAINT tb_perspectiva_pkey PRIMARY KEY (cod_perspectiva);


--
-- TOC entry 2377 (class 2606 OID 191173)
-- Name: tb_produto_etapa tb_produto_etapa_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_produto_etapa
    ADD CONSTRAINT tb_produto_etapa_pkey PRIMARY KEY (cod_produto_etapa);


--
-- TOC entry 2379 (class 2606 OID 191175)
-- Name: tb_programa_trabalho tb_programa_trabalho_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_programa_trabalho
    ADD CONSTRAINT tb_programa_trabalho_pkey PRIMARY KEY (cod_programa_trabalho);


--
-- TOC entry 2383 (class 2606 OID 191177)
-- Name: tb_regiao_administrativa tb_regiao_administrativa_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_regiao_administrativa
    ADD CONSTRAINT tb_regiao_administrativa_pkey PRIMARY KEY (cod_ra);


--
-- TOC entry 2381 (class 2606 OID 191179)
-- Name: tb_regiao tb_regiao_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_regiao
    ADD CONSTRAINT tb_regiao_pkey PRIMARY KEY (cod_regiao);


--
-- TOC entry 2385 (class 2606 OID 191181)
-- Name: tb_regiao_tipo tb_regiao_tipo_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_regiao_tipo
    ADD CONSTRAINT tb_regiao_tipo_pkey PRIMARY KEY (cod_regiao_tipo);


--
-- TOC entry 2389 (class 2606 OID 191183)
-- Name: tb_sag_analise tb_sag_analise_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_analise
    ADD CONSTRAINT tb_sag_analise_pkey PRIMARY KEY (cod_sag, cod_bimestre);


--
-- TOC entry 2391 (class 2606 OID 191185)
-- Name: tb_sag_causa_desvio tb_sag_causa_desvio_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_causa_desvio
    ADD CONSTRAINT tb_sag_causa_desvio_pkey PRIMARY KEY (cod_causa);


--
-- TOC entry 2393 (class 2606 OID 191187)
-- Name: tb_sag_controle_analise tb_sag_controle_analise_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_controle_analise
    ADD CONSTRAINT tb_sag_controle_analise_pkey PRIMARY KEY (cod_controle);


--
-- TOC entry 2395 (class 2606 OID 191189)
-- Name: tb_sag_natureza_desvio tb_sag_natureza_desvio_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_natureza_desvio
    ADD CONSTRAINT tb_sag_natureza_desvio_pkey PRIMARY KEY (cod_natureza);


--
-- TOC entry 2397 (class 2606 OID 191191)
-- Name: tb_sag_periodo tb_sag_periodo_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_periodo
    ADD CONSTRAINT tb_sag_periodo_pkey PRIMARY KEY (cod_chave);


--
-- TOC entry 2387 (class 2606 OID 191193)
-- Name: tb_sag tb_sag_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag
    ADD CONSTRAINT tb_sag_pkey PRIMARY KEY (cod_sag);


--
-- TOC entry 2399 (class 2606 OID 191195)
-- Name: tb_sag_situacao_analise tb_sag_situacao_analise_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_situacao_analise
    ADD CONSTRAINT tb_sag_situacao_analise_pkey PRIMARY KEY (cod_situacao);


--
-- TOC entry 2401 (class 2606 OID 191197)
-- Name: tb_sistema_modulo_acao tb_sistema_modulo_acao_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sistema_modulo_acao
    ADD CONSTRAINT tb_sistema_modulo_acao_pkey PRIMARY KEY (cod_modulo_sistema, cod_modulo_sistema_acao);


--
-- TOC entry 2406 (class 2606 OID 191199)
-- Name: tb_status_modulo tb_status_modulo_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_status_modulo
    ADD CONSTRAINT tb_status_modulo_pkey PRIMARY KEY (cod_status, cod_modulo);


--
-- TOC entry 2403 (class 2606 OID 191201)
-- Name: tb_status tb_status_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_status
    ADD CONSTRAINT tb_status_pkey PRIMARY KEY (cod_status);


--
-- TOC entry 2408 (class 2606 OID 191203)
-- Name: tb_unidade_medida tb_unidade_medida_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_unidade_medida
    ADD CONSTRAINT tb_unidade_medida_pkey PRIMARY KEY (cod_unidade_medida);


--
-- TOC entry 2410 (class 2606 OID 191205)
-- Name: tb_urd tb_urd_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_urd
    ADD CONSTRAINT tb_urd_pkey PRIMARY KEY (cod_urd);


--
-- TOC entry 2415 (class 2606 OID 191207)
-- Name: tb_usuario_orgao tb_usuario_orgao_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_usuario_orgao
    ADD CONSTRAINT tb_usuario_orgao_pkey PRIMARY KEY (cod_usuario, cod_orgao);


--
-- TOC entry 2412 (class 2606 OID 191209)
-- Name: tb_usuario tb_usuario_pkey; Type: CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_usuario
    ADD CONSTRAINT tb_usuario_pkey PRIMARY KEY (cod_usuario);


--
-- TOC entry 2322 (class 1259 OID 191210)
-- Name: uq_tb_cargo; Type: INDEX; Schema: sesplan; Owner: sesplan_app
--

CREATE UNIQUE INDEX uq_tb_cargo ON sesplan.tb_cargo USING btree (txt_cargo);


--
-- TOC entry 2325 (class 1259 OID 191211)
-- Name: uq_tb_diretriz; Type: INDEX; Schema: sesplan; Owner: sesplan_app
--

CREATE UNIQUE INDEX uq_tb_diretriz ON sesplan.tb_diretriz USING btree (cod_eixo, cod_perspectiva, txt_diretriz);


--
-- TOC entry 2328 (class 1259 OID 191212)
-- Name: uq_tb_eixo; Type: INDEX; Schema: sesplan; Owner: sesplan_app
--

CREATE UNIQUE INDEX uq_tb_eixo ON sesplan.tb_eixo USING btree (txt_eixo);


--
-- TOC entry 2349 (class 1259 OID 191213)
-- Name: uq_tb_objetivo; Type: INDEX; Schema: sesplan; Owner: sesplan_app
--

CREATE UNIQUE INDEX uq_tb_objetivo ON sesplan.tb_objetivo USING btree (cod_eixo, cod_perspectiva, cod_diretriz, txt_objetivo);


--
-- TOC entry 2352 (class 1259 OID 191214)
-- Name: uq_tb_objetivo_ppa; Type: INDEX; Schema: sesplan; Owner: sesplan_app
--

CREATE UNIQUE INDEX uq_tb_objetivo_ppa ON sesplan.tb_objetivo_ppa USING btree (cod_eixo, cod_perspectiva, cod_diretriz, cod_objetivo, txt_objetivo_ppa);


--
-- TOC entry 2355 (class 1259 OID 191215)
-- Name: uq_tb_orgao; Type: INDEX; Schema: sesplan; Owner: sesplan_app
--

CREATE UNIQUE INDEX uq_tb_orgao ON sesplan.tb_orgao USING btree (txt_sigla);


--
-- TOC entry 2370 (class 1259 OID 191216)
-- Name: uq_tb_perfil; Type: INDEX; Schema: sesplan; Owner: sesplan_app
--

CREATE UNIQUE INDEX uq_tb_perfil ON sesplan.tb_perfil USING btree (txt_perfil);


--
-- TOC entry 2375 (class 1259 OID 191217)
-- Name: uq_tb_perspectiva; Type: INDEX; Schema: sesplan; Owner: sesplan_app
--

CREATE UNIQUE INDEX uq_tb_perspectiva ON sesplan.tb_perspectiva USING btree (cod_eixo, txt_perspectiva);


--
-- TOC entry 2404 (class 1259 OID 191218)
-- Name: uq_tb_status; Type: INDEX; Schema: sesplan; Owner: sesplan_app
--

CREATE UNIQUE INDEX uq_tb_status ON sesplan.tb_status USING btree (txt_status);


--
-- TOC entry 2413 (class 1259 OID 191219)
-- Name: uq_tb_usuario; Type: INDEX; Schema: sesplan; Owner: sesplan_app
--

CREATE UNIQUE INDEX uq_tb_usuario ON sesplan.tb_usuario USING btree (txt_cpf);


--
-- TOC entry 2419 (class 2606 OID 191220)
-- Name: tb_auditoria_acao fk_tb_aud_mod_aca; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_auditoria_acao
    ADD CONSTRAINT fk_tb_aud_mod_aca FOREIGN KEY (cod_modulo_auditoria) REFERENCES sesplan.tb_auditoria_modulo(cod_modulo_auditoria);


--
-- TOC entry 2416 (class 2606 OID 191225)
-- Name: tb_auditoria fk_tb_auditoria_acao_aud; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_auditoria
    ADD CONSTRAINT fk_tb_auditoria_acao_aud FOREIGN KEY (cod_acao_auditoria) REFERENCES sesplan.tb_auditoria_acao(cod_acao_auditoria);


--
-- TOC entry 2417 (class 2606 OID 191230)
-- Name: tb_auditoria fk_tb_auditoria_orgao; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_auditoria
    ADD CONSTRAINT fk_tb_auditoria_orgao FOREIGN KEY (cod_orgao) REFERENCES sesplan.tb_orgao(cod_orgao);


--
-- TOC entry 2418 (class 2606 OID 191235)
-- Name: tb_auditoria fk_tb_auditoria_usuario; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_auditoria
    ADD CONSTRAINT fk_tb_auditoria_usuario FOREIGN KEY (cod_usuario) REFERENCES sesplan.tb_usuario(cod_usuario);


--
-- TOC entry 2420 (class 2606 OID 191240)
-- Name: tb_diretriz fk_tb_diretriz_eixo; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_diretriz
    ADD CONSTRAINT fk_tb_diretriz_eixo FOREIGN KEY (cod_eixo) REFERENCES sesplan.tb_eixo(cod_eixo);


--
-- TOC entry 2421 (class 2606 OID 191245)
-- Name: tb_diretriz fk_tb_diretriz_perspectiva; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_diretriz
    ADD CONSTRAINT fk_tb_diretriz_perspectiva FOREIGN KEY (cod_perspectiva) REFERENCES sesplan.tb_perspectiva(cod_perspectiva);


--
-- TOC entry 2425 (class 2606 OID 191250)
-- Name: tb_hospital fk_tb_hospital_regiao; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_hospital
    ADD CONSTRAINT fk_tb_hospital_regiao FOREIGN KEY (cod_regiao) REFERENCES sesplan.tb_regiao(cod_regiao);


--
-- TOC entry 2426 (class 2606 OID 191255)
-- Name: tb_indicador fk_tb_indic_tecnic; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador
    ADD CONSTRAINT fk_tb_indic_tecnic FOREIGN KEY (cod_responsavel_tecnico_2) REFERENCES sesplan.tb_orgao(cod_orgao);


--
-- TOC entry 2432 (class 2606 OID 191260)
-- Name: tb_indicador_analise fk_tb_indicador_analise_chave; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador_analise
    ADD CONSTRAINT fk_tb_indicador_analise_chave FOREIGN KEY (cod_chave) REFERENCES sesplan.tb_indicador(cod_chave);


--
-- TOC entry 2433 (class 2606 OID 191265)
-- Name: tb_indicador_analise fk_tb_indicador_analise_status; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador_analise
    ADD CONSTRAINT fk_tb_indicador_analise_status FOREIGN KEY (cod_status) REFERENCES sesplan.tb_status(cod_status);


--
-- TOC entry 2434 (class 2606 OID 191270)
-- Name: tb_indicador_analise fk_tb_indicador_analise_usuario; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador_analise
    ADD CONSTRAINT fk_tb_indicador_analise_usuario FOREIGN KEY (cod_usuario) REFERENCES sesplan.tb_usuario(cod_usuario);


--
-- TOC entry 2435 (class 2606 OID 191275)
-- Name: tb_indicador_meta fk_tb_indicador_meta_indicador; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador_meta
    ADD CONSTRAINT fk_tb_indicador_meta_indicador FOREIGN KEY (cod_indicador) REFERENCES sesplan.tb_indicador(cod_chave);


--
-- TOC entry 2427 (class 2606 OID 191280)
-- Name: tb_indicador fk_tb_indicador_objetivo; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador
    ADD CONSTRAINT fk_tb_indicador_objetivo FOREIGN KEY (cod_objetivo) REFERENCES sesplan.tb_objetivo(cod_objetivo);


--
-- TOC entry 2428 (class 2606 OID 191285)
-- Name: tb_indicador fk_tb_indicador_objetivo_ppa; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador
    ADD CONSTRAINT fk_tb_indicador_objetivo_ppa FOREIGN KEY (cod_objetivo_ppa) REFERENCES sesplan.tb_objetivo_ppa(cod_objetivo_ppa);


--
-- TOC entry 2429 (class 2606 OID 191290)
-- Name: tb_indicador fk_tb_indicador_orgao; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador
    ADD CONSTRAINT fk_tb_indicador_orgao FOREIGN KEY (cod_orgao) REFERENCES sesplan.tb_orgao(cod_orgao);


--
-- TOC entry 2436 (class 2606 OID 191295)
-- Name: tb_indicador_periodo fk_tb_indicador_periodo_usuario; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador_periodo
    ADD CONSTRAINT fk_tb_indicador_periodo_usuario FOREIGN KEY (cod_usuario) REFERENCES sesplan.tb_usuario(cod_usuario);


--
-- TOC entry 2437 (class 2606 OID 191300)
-- Name: tb_indicador_periodo fk_tb_indicador_periodo_usuario_reabrir; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador_periodo
    ADD CONSTRAINT fk_tb_indicador_periodo_usuario_reabrir FOREIGN KEY (cod_usuario_reabrir) REFERENCES sesplan.tb_usuario(cod_usuario);


--
-- TOC entry 2430 (class 2606 OID 191305)
-- Name: tb_indicador fk_tb_indicador_reg_tipo; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador
    ADD CONSTRAINT fk_tb_indicador_reg_tipo FOREIGN KEY (cod_regiao_tipo) REFERENCES sesplan.tb_regiao_tipo(cod_regiao_tipo);


--
-- TOC entry 2431 (class 2606 OID 191310)
-- Name: tb_indicador fk_tb_indicador_respon; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_indicador
    ADD CONSTRAINT fk_tb_indicador_respon FOREIGN KEY (cod_responsavel_tecnico) REFERENCES sesplan.tb_orgao(cod_orgao);


--
-- TOC entry 2422 (class 2606 OID 191315)
-- Name: tb_diretriz fk_tb_objetivo_diretriz; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_diretriz
    ADD CONSTRAINT fk_tb_objetivo_diretriz FOREIGN KEY (cod_diretriz) REFERENCES sesplan.tb_diretriz(cod_diretriz);


--
-- TOC entry 2438 (class 2606 OID 191320)
-- Name: tb_objetivo fk_tb_objetivo_eixo; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_objetivo
    ADD CONSTRAINT fk_tb_objetivo_eixo FOREIGN KEY (cod_eixo) REFERENCES sesplan.tb_eixo(cod_eixo);


--
-- TOC entry 2439 (class 2606 OID 191325)
-- Name: tb_objetivo fk_tb_objetivo_perspectiva; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_objetivo
    ADD CONSTRAINT fk_tb_objetivo_perspectiva FOREIGN KEY (cod_perspectiva) REFERENCES sesplan.tb_perspectiva(cod_perspectiva);


--
-- TOC entry 2452 (class 2606 OID 191330)
-- Name: tb_pas_analise fk_tb_pas_ana; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas_analise
    ADD CONSTRAINT fk_tb_pas_ana FOREIGN KEY (cod_pas) REFERENCES sesplan.tb_pas(cod_pas);


--
-- TOC entry 2453 (class 2606 OID 191335)
-- Name: tb_pas_analise fk_tb_pas_bim; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas_analise
    ADD CONSTRAINT fk_tb_pas_bim FOREIGN KEY (cod_bimestre) REFERENCES sesplan.tb_pas_mes(cod_mes);


--
-- TOC entry 2447 (class 2606 OID 191340)
-- Name: tb_pas fk_tb_pas_controle; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas
    ADD CONSTRAINT fk_tb_pas_controle FOREIGN KEY (cod_controle) REFERENCES sesplan.tb_pas_controle(cod_controle);


--
-- TOC entry 2455 (class 2606 OID 191345)
-- Name: tb_pas_controle_historico fk_tb_pas_hist_pas; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas_controle_historico
    ADD CONSTRAINT fk_tb_pas_hist_pas FOREIGN KEY (cod_pas) REFERENCES sesplan.tb_pas(cod_pas);


--
-- TOC entry 2456 (class 2606 OID 191350)
-- Name: tb_pas_controle_historico fk_tb_pas_hist_usu; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas_controle_historico
    ADD CONSTRAINT fk_tb_pas_hist_usu FOREIGN KEY (cod_usuario) REFERENCES sesplan.tb_usuario(cod_usuario);


--
-- TOC entry 2457 (class 2606 OID 191355)
-- Name: tb_pas_controle_historico fk_tb_pas_hist_usu2; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas_controle_historico
    ADD CONSTRAINT fk_tb_pas_hist_usu2 FOREIGN KEY (cod_usuario_autorizar) REFERENCES sesplan.tb_usuario(cod_usuario);


--
-- TOC entry 2479 (class 2606 OID 191360)
-- Name: tb_status_modulo fk_tb_pas_modulo_stat; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_status_modulo
    ADD CONSTRAINT fk_tb_pas_modulo_stat FOREIGN KEY (cod_modulo) REFERENCES sesplan.tb_modulo(cod_modulo);


--
-- TOC entry 2448 (class 2606 OID 191365)
-- Name: tb_pas fk_tb_pas_objetivo; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas
    ADD CONSTRAINT fk_tb_pas_objetivo FOREIGN KEY (cod_objetivo) REFERENCES sesplan.tb_objetivo(cod_objetivo);


--
-- TOC entry 2449 (class 2606 OID 191370)
-- Name: tb_pas fk_tb_pas_objetivo_ppa; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas
    ADD CONSTRAINT fk_tb_pas_objetivo_ppa FOREIGN KEY (cod_objetivo_ppa) REFERENCES sesplan.tb_objetivo_ppa(cod_objetivo_ppa);


--
-- TOC entry 2450 (class 2606 OID 191375)
-- Name: tb_pas fk_tb_pas_orgao; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas
    ADD CONSTRAINT fk_tb_pas_orgao FOREIGN KEY (cod_orgao) REFERENCES sesplan.tb_orgao(cod_orgao);


--
-- TOC entry 2451 (class 2606 OID 191380)
-- Name: tb_pas fk_tb_pas_parce; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas
    ADD CONSTRAINT fk_tb_pas_parce FOREIGN KEY (cod_parceiro) REFERENCES sesplan.tb_orgao(cod_orgao);


--
-- TOC entry 2458 (class 2606 OID 191385)
-- Name: tb_pas_periodo fk_tb_pas_periodo_usuario; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas_periodo
    ADD CONSTRAINT fk_tb_pas_periodo_usuario FOREIGN KEY (cod_usuario) REFERENCES sesplan.tb_usuario(cod_usuario);


--
-- TOC entry 2459 (class 2606 OID 191390)
-- Name: tb_pas_periodo fk_tb_pas_periodo_usuario_reabrir; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas_periodo
    ADD CONSTRAINT fk_tb_pas_periodo_usuario_reabrir FOREIGN KEY (cod_usuario_reabrir) REFERENCES sesplan.tb_usuario(cod_usuario);


--
-- TOC entry 2480 (class 2606 OID 191395)
-- Name: tb_status_modulo fk_tb_pas_status_mod; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_status_modulo
    ADD CONSTRAINT fk_tb_pas_status_mod FOREIGN KEY (cod_status) REFERENCES sesplan.tb_status(cod_status);


--
-- TOC entry 2454 (class 2606 OID 191400)
-- Name: tb_pas_analise fk_tb_pas_usua; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_pas_analise
    ADD CONSTRAINT fk_tb_pas_usua FOREIGN KEY (cod_usuario) REFERENCES sesplan.tb_usuario(cod_usuario);


--
-- TOC entry 2460 (class 2606 OID 191405)
-- Name: tb_permissao_perfil fk_tb_permissao_perfil; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_permissao_perfil
    ADD CONSTRAINT fk_tb_permissao_perfil FOREIGN KEY (cod_perfil) REFERENCES sesplan.tb_perfil(cod_perfil);


--
-- TOC entry 2461 (class 2606 OID 191410)
-- Name: tb_perspectiva fk_tb_perspectiva_eixo; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_perspectiva
    ADD CONSTRAINT fk_tb_perspectiva_eixo FOREIGN KEY (cod_eixo) REFERENCES sesplan.tb_eixo(cod_eixo);


--
-- TOC entry 2468 (class 2606 OID 191415)
-- Name: tb_regiao_administrativa fk_tb_ra_regiao; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_regiao_administrativa
    ADD CONSTRAINT fk_tb_ra_regiao FOREIGN KEY (cod_regiao) REFERENCES sesplan.tb_regiao(cod_regiao);


--
-- TOC entry 2469 (class 2606 OID 191420)
-- Name: tb_sag_analise fk_tb_sag_an; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_analise
    ADD CONSTRAINT fk_tb_sag_an FOREIGN KEY (cod_status) REFERENCES sesplan.tb_status(cod_status);


--
-- TOC entry 2470 (class 2606 OID 191425)
-- Name: tb_sag_analise fk_tb_sag_an_causa_des; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_analise
    ADD CONSTRAINT fk_tb_sag_an_causa_des FOREIGN KEY (cod_causa_desvio) REFERENCES sesplan.tb_sag_causa_desvio(cod_causa);


--
-- TOC entry 2471 (class 2606 OID 191430)
-- Name: tb_sag_analise fk_tb_sag_an_co; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_analise
    ADD CONSTRAINT fk_tb_sag_an_co FOREIGN KEY (cod_controle) REFERENCES sesplan.tb_sag_controle_analise(cod_controle);


--
-- TOC entry 2472 (class 2606 OID 191435)
-- Name: tb_sag_analise fk_tb_sag_an_natur_des; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_analise
    ADD CONSTRAINT fk_tb_sag_an_natur_des FOREIGN KEY (cod_natureza_desvio) REFERENCES sesplan.tb_sag_natureza_desvio(cod_natureza);


--
-- TOC entry 2473 (class 2606 OID 191440)
-- Name: tb_sag_analise fk_tb_sag_an_s; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_analise
    ADD CONSTRAINT fk_tb_sag_an_s FOREIGN KEY (cod_situacao) REFERENCES sesplan.tb_sag_situacao_analise(cod_situacao);


--
-- TOC entry 2475 (class 2606 OID 191445)
-- Name: tb_sag_periodo fk_tb_sag_periodo_usuario; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_periodo
    ADD CONSTRAINT fk_tb_sag_periodo_usuario FOREIGN KEY (cod_usuario) REFERENCES sesplan.tb_usuario(cod_usuario);


--
-- TOC entry 2476 (class 2606 OID 191450)
-- Name: tb_sag_periodo fk_tb_sag_periodo_usuario_reabrir; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_periodo
    ADD CONSTRAINT fk_tb_sag_periodo_usuario_reabrir FOREIGN KEY (cod_usuario_reabrir) REFERENCES sesplan.tb_usuario(cod_usuario);


--
-- TOC entry 2474 (class 2606 OID 191455)
-- Name: tb_sag_analise fk_tb_sag_sag; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sag_analise
    ADD CONSTRAINT fk_tb_sag_sag FOREIGN KEY (cod_sag) REFERENCES sesplan.tb_sag(cod_sag);


--
-- TOC entry 2477 (class 2606 OID 191460)
-- Name: tb_sistema_modulo_acao fk_tb_sis_mod_ac; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sistema_modulo_acao
    ADD CONSTRAINT fk_tb_sis_mod_ac FOREIGN KEY (cod_modulo_sistema) REFERENCES sesplan.tb_modulo_sistema(cod_modulo_sistema);


--
-- TOC entry 2478 (class 2606 OID 191465)
-- Name: tb_sistema_modulo_acao fk_tb_sis_mod_ac2; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_sistema_modulo_acao
    ADD CONSTRAINT fk_tb_sis_mod_ac2 FOREIGN KEY (cod_modulo_sistema_acao) REFERENCES sesplan.tb_modulo_sistema_acao(cod_modulo_sistema_acao);


--
-- TOC entry 2481 (class 2606 OID 191470)
-- Name: tb_usuario fk_tb_usuario_cargo; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_usuario
    ADD CONSTRAINT fk_tb_usuario_cargo FOREIGN KEY (cod_cargo) REFERENCES sesplan.tb_cargo(cod_cargo);


--
-- TOC entry 2482 (class 2606 OID 191475)
-- Name: tb_usuario fk_tb_usuario_orgao; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_usuario
    ADD CONSTRAINT fk_tb_usuario_orgao FOREIGN KEY (cod_orgao) REFERENCES sesplan.tb_orgao(cod_orgao);


--
-- TOC entry 2483 (class 2606 OID 191480)
-- Name: tb_usuario fk_tb_usuario_perfil; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_usuario
    ADD CONSTRAINT fk_tb_usuario_perfil FOREIGN KEY (cod_perfil) REFERENCES sesplan.tb_perfil(cod_perfil);


--
-- TOC entry 2484 (class 2606 OID 191485)
-- Name: tb_usuario_orgao fk_tb_usuario_unidade_orgao; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_usuario_orgao
    ADD CONSTRAINT fk_tb_usuario_unidade_orgao FOREIGN KEY (cod_orgao) REFERENCES sesplan.tb_orgao(cod_orgao);


--
-- TOC entry 2485 (class 2606 OID 191490)
-- Name: tb_usuario_orgao fk_tb_usuario_unidade_usu; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_usuario_orgao
    ADD CONSTRAINT fk_tb_usuario_unidade_usu FOREIGN KEY (cod_usuario) REFERENCES sesplan.tb_usuario(cod_usuario);


--
-- TOC entry 2423 (class 2606 OID 191495)
-- Name: tb_diretriz tb_diretriz_cod_eixo_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_diretriz
    ADD CONSTRAINT tb_diretriz_cod_eixo_fkey FOREIGN KEY (cod_eixo) REFERENCES sesplan.tb_eixo(cod_eixo);


--
-- TOC entry 2424 (class 2606 OID 191500)
-- Name: tb_diretriz tb_diretriz_cod_perspectiva_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_diretriz
    ADD CONSTRAINT tb_diretriz_cod_perspectiva_fkey FOREIGN KEY (cod_perspectiva) REFERENCES sesplan.tb_perspectiva(cod_perspectiva);


--
-- TOC entry 2440 (class 2606 OID 191505)
-- Name: tb_objetivo tb_objetivo_cod_diretriz_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_objetivo
    ADD CONSTRAINT tb_objetivo_cod_diretriz_fkey FOREIGN KEY (cod_diretriz) REFERENCES sesplan.tb_diretriz(cod_diretriz);


--
-- TOC entry 2441 (class 2606 OID 191510)
-- Name: tb_objetivo tb_objetivo_cod_eixo_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_objetivo
    ADD CONSTRAINT tb_objetivo_cod_eixo_fkey FOREIGN KEY (cod_eixo) REFERENCES sesplan.tb_eixo(cod_eixo);


--
-- TOC entry 2442 (class 2606 OID 191515)
-- Name: tb_objetivo tb_objetivo_cod_perspectiva_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_objetivo
    ADD CONSTRAINT tb_objetivo_cod_perspectiva_fkey FOREIGN KEY (cod_perspectiva) REFERENCES sesplan.tb_perspectiva(cod_perspectiva);


--
-- TOC entry 2443 (class 2606 OID 191520)
-- Name: tb_objetivo_ppa tb_objetivo_ppa_cod_diretriz_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_objetivo_ppa
    ADD CONSTRAINT tb_objetivo_ppa_cod_diretriz_fkey FOREIGN KEY (cod_diretriz) REFERENCES sesplan.tb_diretriz(cod_diretriz);


--
-- TOC entry 2444 (class 2606 OID 191525)
-- Name: tb_objetivo_ppa tb_objetivo_ppa_cod_eixo_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_objetivo_ppa
    ADD CONSTRAINT tb_objetivo_ppa_cod_eixo_fkey FOREIGN KEY (cod_eixo) REFERENCES sesplan.tb_eixo(cod_eixo);


--
-- TOC entry 2445 (class 2606 OID 191530)
-- Name: tb_objetivo_ppa tb_objetivo_ppa_cod_objetivo_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_objetivo_ppa
    ADD CONSTRAINT tb_objetivo_ppa_cod_objetivo_fkey FOREIGN KEY (cod_objetivo) REFERENCES sesplan.tb_objetivo(cod_objetivo);


--
-- TOC entry 2446 (class 2606 OID 191535)
-- Name: tb_objetivo_ppa tb_objetivo_ppa_cod_perspectiva_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_objetivo_ppa
    ADD CONSTRAINT tb_objetivo_ppa_cod_perspectiva_fkey FOREIGN KEY (cod_perspectiva) REFERENCES sesplan.tb_perspectiva(cod_perspectiva);


--
-- TOC entry 2462 (class 2606 OID 191540)
-- Name: tb_perspectiva tb_perspectiva_cod_eixo_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_perspectiva
    ADD CONSTRAINT tb_perspectiva_cod_eixo_fkey FOREIGN KEY (cod_eixo) REFERENCES sesplan.tb_eixo(cod_eixo);


--
-- TOC entry 2463 (class 2606 OID 191545)
-- Name: tb_programa_trabalho tb_programa_trabalho_cod_diretriz_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_programa_trabalho
    ADD CONSTRAINT tb_programa_trabalho_cod_diretriz_fkey FOREIGN KEY (cod_diretriz) REFERENCES sesplan.tb_diretriz(cod_diretriz);


--
-- TOC entry 2464 (class 2606 OID 191550)
-- Name: tb_programa_trabalho tb_programa_trabalho_cod_eixo_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_programa_trabalho
    ADD CONSTRAINT tb_programa_trabalho_cod_eixo_fkey FOREIGN KEY (cod_eixo) REFERENCES sesplan.tb_eixo(cod_eixo);


--
-- TOC entry 2465 (class 2606 OID 191555)
-- Name: tb_programa_trabalho tb_programa_trabalho_cod_objetivo_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_programa_trabalho
    ADD CONSTRAINT tb_programa_trabalho_cod_objetivo_fkey FOREIGN KEY (cod_objetivo) REFERENCES sesplan.tb_objetivo(cod_objetivo);


--
-- TOC entry 2466 (class 2606 OID 191560)
-- Name: tb_programa_trabalho tb_programa_trabalho_cod_objetivo_ppa_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_programa_trabalho
    ADD CONSTRAINT tb_programa_trabalho_cod_objetivo_ppa_fkey FOREIGN KEY (cod_objetivo_ppa) REFERENCES sesplan.tb_objetivo_ppa(cod_objetivo_ppa);


--
-- TOC entry 2467 (class 2606 OID 191565)
-- Name: tb_programa_trabalho tb_programa_trabalho_cod_perspectiva_fkey; Type: FK CONSTRAINT; Schema: sesplan; Owner: sesplan_app
--

ALTER TABLE ONLY sesplan.tb_programa_trabalho
    ADD CONSTRAINT tb_programa_trabalho_cod_perspectiva_fkey FOREIGN KEY (cod_perspectiva) REFERENCES sesplan.tb_perspectiva(cod_perspectiva);


--
-- TOC entry 2669 (class 0 OID 0)
-- Dependencies: 5
-- Name: SCHEMA sesplan; Type: ACL; Schema: -; Owner: sesplan_app
--

GRANT USAGE ON SCHEMA sesplan TO sesplan_user;
GRANT ALL ON SCHEMA sesplan TO dbsistemas;


--
-- TOC entry 2670 (class 0 OID 0)
-- Dependencies: 259
-- Name: FUNCTION sp_execucao_orcamentaria(); Type: ACL; Schema: sesplan; Owner: postgres
--

GRANT ALL ON FUNCTION sesplan.sp_execucao_orcamentaria() TO sesplan_app;


--
-- TOC entry 2671 (class 0 OID 0)
-- Dependencies: 186
-- Name: SEQUENCE cod_produto_etapa_seq; Type: ACL; Schema: sesplan; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE sesplan.cod_produto_etapa_seq TO sesplan_app;


--
-- TOC entry 2672 (class 0 OID 0)
-- Dependencies: 187
-- Name: SEQUENCE cod_programa_trabalho_seq; Type: ACL; Schema: sesplan; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE sesplan.cod_programa_trabalho_seq TO sesplan_app;


--
-- TOC entry 2673 (class 0 OID 0)
-- Dependencies: 188
-- Name: SEQUENCE cod_sag_analise_seq; Type: ACL; Schema: sesplan; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE sesplan.cod_sag_analise_seq TO sesplan_app;


--
-- TOC entry 2674 (class 0 OID 0)
-- Dependencies: 189
-- Name: SEQUENCE cod_sag_seq; Type: ACL; Schema: sesplan; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE sesplan.cod_sag_seq TO sesplan_app;


--
-- TOC entry 2675 (class 0 OID 0)
-- Dependencies: 190
-- Name: SEQUENCE cod_unidade_medida_seq; Type: ACL; Schema: sesplan; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE sesplan.cod_unidade_medida_seq TO sesplan_app;


--
-- TOC entry 2676 (class 0 OID 0)
-- Dependencies: 191
-- Name: SEQUENCE indicador; Type: ACL; Schema: sesplan; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE sesplan.indicador TO sesplan_app;


--
-- TOC entry 2677 (class 0 OID 0)
-- Dependencies: 192
-- Name: SEQUENCE pas; Type: ACL; Schema: sesplan; Owner: postgres
--

GRANT SELECT,USAGE ON SEQUENCE sesplan.pas TO sesplan_app;


--
-- TOC entry 2678 (class 0 OID 0)
-- Dependencies: 194
-- Name: TABLE tab_siggo_sesplan; Type: ACL; Schema: sesplan; Owner: postgres
--

GRANT ALL ON TABLE sesplan.tab_siggo_sesplan TO sesplan_app;


--
-- TOC entry 2679 (class 0 OID 0)
-- Dependencies: 196
-- Name: TABLE tb_auditoria; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT SELECT ON TABLE sesplan.tb_auditoria TO sesplan_user;


--
-- TOC entry 2680 (class 0 OID 0)
-- Dependencies: 197
-- Name: TABLE tb_auditoria_acao; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT SELECT ON TABLE sesplan.tb_auditoria_acao TO sesplan_user;


--
-- TOC entry 2681 (class 0 OID 0)
-- Dependencies: 198
-- Name: TABLE tb_auditoria_modulo; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT SELECT ON TABLE sesplan.tb_auditoria_modulo TO sesplan_user;


--
-- TOC entry 2682 (class 0 OID 0)
-- Dependencies: 199
-- Name: TABLE tb_cargo; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_cargo TO sesplan_user;


--
-- TOC entry 2683 (class 0 OID 0)
-- Dependencies: 200
-- Name: TABLE tb_diretriz; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_diretriz TO sesplan_user;


--
-- TOC entry 2684 (class 0 OID 0)
-- Dependencies: 201
-- Name: TABLE tb_eixo; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_eixo TO sesplan_user;


--
-- TOC entry 2685 (class 0 OID 0)
-- Dependencies: 203
-- Name: TABLE tb_indicador; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_indicador TO sesplan_user;


--
-- TOC entry 2686 (class 0 OID 0)
-- Dependencies: 204
-- Name: TABLE tb_indicador_analise; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_indicador_analise TO sesplan_user;


--
-- TOC entry 2687 (class 0 OID 0)
-- Dependencies: 205
-- Name: TABLE tb_indicador_analise_historico; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT SELECT ON TABLE sesplan.tb_indicador_analise_historico TO sesplan_user;


--
-- TOC entry 2688 (class 0 OID 0)
-- Dependencies: 207
-- Name: TABLE tb_indicador_meta; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_indicador_meta TO sesplan_user;


--
-- TOC entry 2689 (class 0 OID 0)
-- Dependencies: 208
-- Name: TABLE tb_indicador_periodo; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_indicador_periodo TO sesplan_user;


--
-- TOC entry 2690 (class 0 OID 0)
-- Dependencies: 209
-- Name: TABLE tb_mes; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_mes TO sesplan_user;


--
-- TOC entry 2691 (class 0 OID 0)
-- Dependencies: 210
-- Name: TABLE tb_modulo; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_modulo TO sesplan_user;


--
-- TOC entry 2692 (class 0 OID 0)
-- Dependencies: 213
-- Name: TABLE tb_objetivo; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_objetivo TO sesplan_user;


--
-- TOC entry 2693 (class 0 OID 0)
-- Dependencies: 214
-- Name: TABLE tb_objetivo_ppa; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_objetivo_ppa TO sesplan_user;


--
-- TOC entry 2694 (class 0 OID 0)
-- Dependencies: 215
-- Name: TABLE tb_orgao; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_orgao TO sesplan_user;


--
-- TOC entry 2695 (class 0 OID 0)
-- Dependencies: 216
-- Name: TABLE tb_pas; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_pas TO sesplan_user;


--
-- TOC entry 2696 (class 0 OID 0)
-- Dependencies: 223
-- Name: TABLE tb_perfil; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_perfil TO sesplan_user;


--
-- TOC entry 2697 (class 0 OID 0)
-- Dependencies: 225
-- Name: TABLE tb_perspectiva; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_perspectiva TO sesplan_user;


--
-- TOC entry 2698 (class 0 OID 0)
-- Dependencies: 226
-- Name: TABLE tb_produto_etapa; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_produto_etapa TO sesplan_user;


--
-- TOC entry 2699 (class 0 OID 0)
-- Dependencies: 227
-- Name: TABLE tb_programa_trabalho; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_programa_trabalho TO sesplan_user;


--
-- TOC entry 2700 (class 0 OID 0)
-- Dependencies: 231
-- Name: TABLE tb_sag; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_sag TO sesplan_user;


--
-- TOC entry 2701 (class 0 OID 0)
-- Dependencies: 240
-- Name: TABLE tb_status; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_status TO sesplan_user;


--
-- TOC entry 2702 (class 0 OID 0)
-- Dependencies: 241
-- Name: TABLE tb_status_modulo; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_status_modulo TO sesplan_user;


--
-- TOC entry 2703 (class 0 OID 0)
-- Dependencies: 242
-- Name: TABLE tb_unidade_medida; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_unidade_medida TO sesplan_user;


--
-- TOC entry 2704 (class 0 OID 0)
-- Dependencies: 244
-- Name: TABLE tb_usuario; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_usuario TO sesplan_user;


--
-- TOC entry 2705 (class 0 OID 0)
-- Dependencies: 245
-- Name: TABLE tb_usuario_orgao; Type: ACL; Schema: sesplan; Owner: sesplan_app
--

GRANT ALL ON TABLE sesplan.tb_usuario_orgao TO sesplan_user;


-- Completed on 2018-09-20 00:24:21

--
-- PostgreSQL database dump complete
--

