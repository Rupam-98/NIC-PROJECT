PGDMP  3    5                }            PROJECT    17.5    17.5     .           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            /           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            0           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            1           1262    16567    PROJECT    DATABASE     |   CREATE DATABASE "PROJECT" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_India.1252';
    DROP DATABASE "PROJECT";
                     postgres    false            �            1259    16695    branches    TABLE       CREATE TABLE public.branches (
    id integer NOT NULL,
    branchcode character varying(20) NOT NULL,
    deptcode character varying(20) NOT NULL,
    branch_type character varying(50) NOT NULL,
    branch_name character varying(100) NOT NULL,
    beeocode character varying(20),
    officer_name character varying(100) NOT NULL,
    officer_designation character varying(100) NOT NULL,
    office_email character varying(100) NOT NULL,
    office_phone character varying(20) NOT NULL,
    office_address text NOT NULL
);
    DROP TABLE public.branches;
       public         heap r       postgres    false            �            1259    16694    branches_id_seq    SEQUENCE     �   CREATE SEQUENCE public.branches_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.branches_id_seq;
       public               postgres    false    230            2           0    0    branches_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.branches_id_seq OWNED BY public.branches.id;
          public               postgres    false    229            �           2604    16698    branches id    DEFAULT     j   ALTER TABLE ONLY public.branches ALTER COLUMN id SET DEFAULT nextval('public.branches_id_seq'::regclass);
 :   ALTER TABLE public.branches ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    229    230    230            +          0    16695    branches 
   TABLE DATA           �   COPY public.branches (id, branchcode, deptcode, branch_type, branch_name, beeocode, officer_name, officer_designation, office_email, office_phone, office_address) FROM stdin;
    public               postgres    false    230   u       3           0    0    branches_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.branches_id_seq', 1, false);
          public               postgres    false    229            �           2606    16704 "   branches branches_office_email_key 
   CONSTRAINT     e   ALTER TABLE ONLY public.branches
    ADD CONSTRAINT branches_office_email_key UNIQUE (office_email);
 L   ALTER TABLE ONLY public.branches DROP CONSTRAINT branches_office_email_key;
       public                 postgres    false    230            �           2606    16706 "   branches branches_office_phone_key 
   CONSTRAINT     e   ALTER TABLE ONLY public.branches
    ADD CONSTRAINT branches_office_phone_key UNIQUE (office_phone);
 L   ALTER TABLE ONLY public.branches DROP CONSTRAINT branches_office_phone_key;
       public                 postgres    false    230            �           2606    16702    branches branches_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.branches
    ADD CONSTRAINT branches_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.branches DROP CONSTRAINT branches_pkey;
       public                 postgres    false    230            +      x������ � �     