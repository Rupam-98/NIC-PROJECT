PGDMP  3    7    
            }            project    17.5    17.5     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false                        0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false                       1262    16461    project    DATABASE     z   CREATE DATABASE project WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_India.1252';
    DROP DATABASE project;
                     postgres    false            �            1259    16558    dept_admins    TABLE     �  CREATE TABLE public.dept_admins (
    id integer NOT NULL,
    dept_code character varying(50) NOT NULL,
    dept_name character varying(100) NOT NULL,
    officer_name character varying(100) NOT NULL,
    designation character varying(50) NOT NULL,
    district character varying(50) NOT NULL,
    email character varying(100) NOT NULL,
    phone character varying(20) NOT NULL,
    username character varying(50) NOT NULL,
    password character varying(255) NOT NULL
);
    DROP TABLE public.dept_admins;
       public         heap r       postgres    false            �            1259    16557    dept_admins_id_seq    SEQUENCE     �   CREATE SEQUENCE public.dept_admins_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.dept_admins_id_seq;
       public               postgres    false    226                       0    0    dept_admins_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.dept_admins_id_seq OWNED BY public.dept_admins.id;
          public               postgres    false    225            f           2604    16561    dept_admins id    DEFAULT     p   ALTER TABLE ONLY public.dept_admins ALTER COLUMN id SET DEFAULT nextval('public.dept_admins_id_seq'::regclass);
 =   ALTER TABLE public.dept_admins ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    226    225    226            �          0    16558    dept_admins 
   TABLE DATA           �   COPY public.dept_admins (id, dept_code, dept_name, officer_name, designation, district, email, phone, username, password) FROM stdin;
    public               postgres    false    226   �                  0    0    dept_admins_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.dept_admins_id_seq', 1, false);
          public               postgres    false    225            h           2606    16565    dept_admins dept_admins_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.dept_admins
    ADD CONSTRAINT dept_admins_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.dept_admins DROP CONSTRAINT dept_admins_pkey;
       public                 postgres    false    226            �      x������ � �     