PGDMP  ;    ,                }            project    17.5    17.5     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            �           1262    16461    project    DATABASE     z   CREATE DATABASE project WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_India.1252';
    DROP DATABASE project;
                     postgres    false            �            1259    16466 
   dept_entry    TABLE     p  CREATE TABLE public.dept_entry (
    id integer NOT NULL,
    dept_type character varying(100),
    dept_code character varying(50),
    dept_name character varying(255),
    officer_name character varying(255),
    officer_designation character varying(100),
    office_email character varying(255),
    office_phone character varying(50),
    office_address text
);
    DROP TABLE public.dept_entry;
       public         heap r       postgres    false            �            1259    16465    dept_entry_id_seq    SEQUENCE     �   CREATE SEQUENCE public.dept_entry_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.dept_entry_id_seq;
       public               postgres    false    218            �           0    0    dept_entry_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.dept_entry_id_seq OWNED BY public.dept_entry.id;
          public               postgres    false    217            V           2604    16469    dept_entry id    DEFAULT     n   ALTER TABLE ONLY public.dept_entry ALTER COLUMN id SET DEFAULT nextval('public.dept_entry_id_seq'::regclass);
 <   ALTER TABLE public.dept_entry ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    218    217    218            �          0    16466 
   dept_entry 
   TABLE DATA           �   COPY public.dept_entry (id, dept_type, dept_code, dept_name, officer_name, officer_designation, office_email, office_phone, office_address) FROM stdin;
    public               postgres    false    218   �       �           0    0    dept_entry_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.dept_entry_id_seq', 1, false);
          public               postgres    false    217            X           2606    16475 #   dept_entry dept_entry_dept_code_key 
   CONSTRAINT     c   ALTER TABLE ONLY public.dept_entry
    ADD CONSTRAINT dept_entry_dept_code_key UNIQUE (dept_code);
 M   ALTER TABLE ONLY public.dept_entry DROP CONSTRAINT dept_entry_dept_code_key;
       public                 postgres    false    218            Z           2606    16473    dept_entry dept_entry_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.dept_entry
    ADD CONSTRAINT dept_entry_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.dept_entry DROP CONSTRAINT dept_entry_pkey;
       public                 postgres    false    218            �      x������ � �     