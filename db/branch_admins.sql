PGDMP  2    '                }            PROJECT    17.5    17.5     -           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            .           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            /           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            0           1262    16567    PROJECT    DATABASE     |   CREATE DATABASE "PROJECT" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_India.1252';
    DROP DATABASE "PROJECT";
                     postgres    false            �            1259    16669    branch_admins    TABLE       CREATE TABLE public.branch_admins (
    id integer NOT NULL,
    branch_code character varying(20) NOT NULL,
    dept_code character varying(20) NOT NULL,
    branch_name character varying(100) NOT NULL,
    officer_name character varying(100) NOT NULL,
    designation character varying(100) NOT NULL,
    district character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    phone character varying(20) NOT NULL,
    username character varying(50) NOT NULL,
    password character varying(255) NOT NULL
);
 !   DROP TABLE public.branch_admins;
       public         heap r       postgres    false            �            1259    16668    branch_admins_id_seq    SEQUENCE     �   CREATE SEQUENCE public.branch_admins_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.branch_admins_id_seq;
       public               postgres    false    231            1           0    0    branch_admins_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.branch_admins_id_seq OWNED BY public.branch_admins.id;
          public               postgres    false    230            �           2604    16672    branch_admins id    DEFAULT     t   ALTER TABLE ONLY public.branch_admins ALTER COLUMN id SET DEFAULT nextval('public.branch_admins_id_seq'::regclass);
 ?   ALTER TABLE public.branch_admins ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    230    231    231            *          0    16669    branch_admins 
   TABLE DATA           �   COPY public.branch_admins (id, branch_code, dept_code, branch_name, officer_name, designation, district, email, phone, username, password) FROM stdin;
    public               postgres    false    231   y       2           0    0    branch_admins_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.branch_admins_id_seq', 1, false);
          public               postgres    false    230            �           2606    16676     branch_admins branch_admins_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.branch_admins
    ADD CONSTRAINT branch_admins_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.branch_admins DROP CONSTRAINT branch_admins_pkey;
       public                 postgres    false    231            �           2606    16678 (   branch_admins branch_admins_username_key 
   CONSTRAINT     g   ALTER TABLE ONLY public.branch_admins
    ADD CONSTRAINT branch_admins_username_key UNIQUE (username);
 R   ALTER TABLE ONLY public.branch_admins DROP CONSTRAINT branch_admins_username_key;
       public                 postgres    false    231            *      x������ � �     