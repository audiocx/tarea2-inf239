--
-- PostgreSQL database dump
--

-- Dumped from database version 14.1
-- Dumped by pg_dump version 14.1

-- Started on 2021-12-09 22:53:11

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 215 (class 1259 OID 16555)
-- Name: Anuncio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Anuncio" (
    "IDAnuncio" integer NOT NULL,
    "Descripcion" character varying(400),
    "CantidadDisponible" integer,
    "FechaPublicacion" date,
    "IDVendedor" character varying(12) NOT NULL,
    "IDProducto" integer NOT NULL
);


ALTER TABLE public."Anuncio" OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 16554)
-- Name: Anuncio_IDAnuncio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public."Anuncio" ALTER COLUMN "IDAnuncio" ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public."Anuncio_IDAnuncio_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 219 (class 1259 OID 16675)
-- Name: Calificacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Calificacion" (
    "IDComprador" character varying(12) NOT NULL,
    "IDAnuncio" integer NOT NULL,
    "Calificacion" integer
);


ALTER TABLE public."Calificacion" OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16587)
-- Name: Carrito; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Carrito" (
    "ROLUsuario" character varying(12) NOT NULL,
    "IDAnuncio" integer NOT NULL,
    "CantidadCompra" integer DEFAULT 0,
    "Total" integer DEFAULT 0
);


ALTER TABLE public."Carrito" OWNER TO postgres;

--
-- TOC entry 213 (class 1259 OID 16431)
-- Name: Categoria; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Categoria" (
    "IDProducto" integer NOT NULL,
    "Categoria" character varying(30) NOT NULL
);


ALTER TABLE public."Categoria" OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16660)
-- Name: Comentario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Comentario" (
    "IDComprador" character varying(12) NOT NULL,
    "IDAnuncio" integer NOT NULL,
    "FechaComentario" timestamp without time zone NOT NULL,
    "Comentario" character varying(400)
);


ALTER TABLE public."Comentario" OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 16423)
-- Name: Producto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Producto" (
    "IDProducto" integer NOT NULL,
    "Nombre" character varying(30) NOT NULL,
    "Precio" integer DEFAULT 0 NOT NULL,
    "Promedio" numeric(3,2) DEFAULT NULL::numeric
);


ALTER TABLE public."Producto" OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 16422)
-- Name: Producto_IDProducto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."Producto_IDProducto_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Producto_IDProducto_seq" OWNER TO postgres;

--
-- TOC entry 3384 (class 0 OID 0)
-- Dependencies: 211
-- Name: Producto_IDProducto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."Producto_IDProducto_seq" OWNED BY public."Producto"."IDProducto";


--
-- TOC entry 220 (class 1259 OID 16682)
-- Name: ProductosMejorCalificados; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public."ProductosMejorCalificados" AS
 SELECT "Producto"."IDProducto",
    "Producto"."Nombre",
    "Producto"."Precio",
    "Producto"."Promedio"
   FROM public."Producto"
  ORDER BY "Producto"."Promedio" DESC;


ALTER TABLE public."ProductosMejorCalificados" OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 16565)
-- Name: Transaccion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Transaccion" (
    "IDComprador" character varying(12) NOT NULL,
    "IDVendedor" character varying(12) NOT NULL,
    "IDAnuncio" integer NOT NULL,
    "IDProducto" integer NOT NULL,
    "FechaTransaccion" timestamp without time zone NOT NULL,
    "Cantidad" integer DEFAULT 0,
    "Total" integer DEFAULT 0
);


ALTER TABLE public."Transaccion" OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 16400)
-- Name: Usuario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Usuario" (
    "Rol" character varying(12) DEFAULT NULL::character varying NOT NULL,
    "Nombre" character varying(30) DEFAULT NULL::character varying,
    "Correo" character varying(30) DEFAULT NULL::character varying,
    "FechaNacimiento" date,
    "Contrasena" character varying(70) NOT NULL,
    "Estado" boolean DEFAULT true
);


ALTER TABLE public."Usuario" OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 16395)
-- Name: test; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.test (
    nombre character varying(50) NOT NULL,
    apellido character varying(50)
);


ALTER TABLE public.test OWNER TO postgres;

--
-- TOC entry 3205 (class 2604 OID 16426)
-- Name: Producto IDProducto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Producto" ALTER COLUMN "IDProducto" SET DEFAULT nextval('public."Producto_IDProducto_seq"'::regclass);


--
-- TOC entry 3221 (class 2606 OID 16559)
-- Name: Anuncio Anuncio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Anuncio"
    ADD CONSTRAINT "Anuncio_pkey" PRIMARY KEY ("IDAnuncio");


--
-- TOC entry 3229 (class 2606 OID 16679)
-- Name: Calificacion Calificacion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Calificacion"
    ADD CONSTRAINT "Calificacion_pkey" PRIMARY KEY ("IDComprador", "IDAnuncio");


--
-- TOC entry 3225 (class 2606 OID 16593)
-- Name: Carrito Carrito_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Carrito"
    ADD CONSTRAINT "Carrito_pkey" PRIMARY KEY ("ROLUsuario", "IDAnuncio");


--
-- TOC entry 3219 (class 2606 OID 16435)
-- Name: Categoria Categoria_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Categoria"
    ADD CONSTRAINT "Categoria_pkey" PRIMARY KEY ("IDProducto", "Categoria");


--
-- TOC entry 3227 (class 2606 OID 16664)
-- Name: Comentario Comentario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Comentario"
    ADD CONSTRAINT "Comentario_pkey" PRIMARY KEY ("IDComprador", "IDAnuncio", "FechaComentario");


--
-- TOC entry 3217 (class 2606 OID 16430)
-- Name: Producto Producto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Producto"
    ADD CONSTRAINT "Producto_pkey" PRIMARY KEY ("IDProducto");


--
-- TOC entry 3223 (class 2606 OID 16571)
-- Name: Transaccion Transaccion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Transaccion"
    ADD CONSTRAINT "Transaccion_pkey" PRIMARY KEY ("IDComprador", "IDVendedor", "IDAnuncio", "IDProducto", "FechaTransaccion");


--
-- TOC entry 3215 (class 2606 OID 16406)
-- Name: Usuario Usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Usuario"
    ADD CONSTRAINT "Usuario_pkey" PRIMARY KEY ("Rol");


--
-- TOC entry 3213 (class 2606 OID 16399)
-- Name: test id; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.test
    ADD CONSTRAINT id PRIMARY KEY (nombre);


--
-- TOC entry 3230 (class 2606 OID 16436)
-- Name: Categoria IDProducto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Categoria"
    ADD CONSTRAINT "IDProducto" FOREIGN KEY ("IDProducto") REFERENCES public."Producto"("IDProducto");


--
-- TOC entry 3234 (class 2606 OID 16582)
-- Name: Transaccion fk_anuncio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Transaccion"
    ADD CONSTRAINT fk_anuncio FOREIGN KEY ("IDAnuncio") REFERENCES public."Anuncio"("IDAnuncio") ON DELETE CASCADE;


--
-- TOC entry 3236 (class 2606 OID 16599)
-- Name: Carrito fk_anuncio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Carrito"
    ADD CONSTRAINT fk_anuncio FOREIGN KEY ("IDAnuncio") REFERENCES public."Anuncio"("IDAnuncio") ON DELETE CASCADE;


--
-- TOC entry 3238 (class 2606 OID 16670)
-- Name: Comentario fk_anuncio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Comentario"
    ADD CONSTRAINT fk_anuncio FOREIGN KEY ("IDAnuncio") REFERENCES public."Anuncio"("IDAnuncio") ON DELETE CASCADE;


--
-- TOC entry 3232 (class 2606 OID 16572)
-- Name: Transaccion fk_comprador; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Transaccion"
    ADD CONSTRAINT fk_comprador FOREIGN KEY ("IDComprador") REFERENCES public."Usuario"("Rol") ON DELETE CASCADE;


--
-- TOC entry 3231 (class 2606 OID 16560)
-- Name: Anuncio fk_rol; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Anuncio"
    ADD CONSTRAINT fk_rol FOREIGN KEY ("IDVendedor") REFERENCES public."Usuario"("Rol") ON DELETE CASCADE;


--
-- TOC entry 3235 (class 2606 OID 16594)
-- Name: Carrito fk_rol; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Carrito"
    ADD CONSTRAINT fk_rol FOREIGN KEY ("ROLUsuario") REFERENCES public."Usuario"("Rol") ON DELETE CASCADE;


--
-- TOC entry 3237 (class 2606 OID 16665)
-- Name: Comentario fk_rol; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Comentario"
    ADD CONSTRAINT fk_rol FOREIGN KEY ("IDComprador") REFERENCES public."Usuario"("Rol") ON DELETE CASCADE;


--
-- TOC entry 3233 (class 2606 OID 16577)
-- Name: Transaccion fk_vendedor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Transaccion"
    ADD CONSTRAINT fk_vendedor FOREIGN KEY ("IDVendedor") REFERENCES public."Usuario"("Rol") ON DELETE CASCADE;


-- Completed on 2021-12-09 22:53:11

--
-- PostgreSQL database dump complete
--

