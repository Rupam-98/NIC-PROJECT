PGDMP                      }            PROJECT    17.5    17.5     &           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            '           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            (           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            )           1262    16567    PROJECT    DATABASE     |   CREATE DATABASE "PROJECT" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_India.1252';
    DROP DATABASE "PROJECT";
                     postgres    false            �            1259    16732 
   dept_entry    TABLE       CREATE TABLE public.dept_entry (
    id integer NOT NULL,
    dept_type character varying(100) NOT NULL,
    dept_code character varying(10) NOT NULL,
    dept_name character varying(100) NOT NULL,
    address text NOT NULL,
    head character varying(100) NOT NULL
);
    DROP TABLE public.dept_entry;
       public         heap r       postgres    false            �            1259    16731    dept_entry_id_seq    SEQUENCE     �   CREATE SEQUENCE public.dept_entry_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.dept_entry_id_seq;
       public               postgres    false    226            *           0    0    dept_entry_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.dept_entry_id_seq OWNED BY public.dept_entry.id;
          public               postgres    false    225            �           2604    16735    dept_entry id    DEFAULT     n   ALTER TABLE ONLY public.dept_entry ALTER COLUMN id SET DEFAULT nextval('public.dept_entry_id_seq'::regclass);
 <   ALTER TABLE public.dept_entry ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    226    225    226            #          0    16732 
   dept_entry 
   TABLE DATA           X   COPY public.dept_entry (id, dept_type, dept_code, dept_name, address, head) FROM stdin;
    public               postgres    false    226   �       +           0    0    dept_entry_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.dept_entry_id_seq', 1, true);
          public               postgres    false    225            �           2606    16739    dept_entry dept_entry_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.dept_entry
    ADD CONSTRAINT dept_entry_pkey PRIMARY KEY (dept_code);
 D   ALTER TABLE ONLY public.dept_entry DROP CONSTRAINT dept_entry_pkey;
       public                 postgres    false    226            #   F   x�3���4400�t�,.)�L.Qp����,.���K-R�OK�LN���/*�P�I����-(-�tq����� dLK     