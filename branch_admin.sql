PGDMP      7    
            }            project    17.5    17.5     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false                        0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false                       1262    16461    project    DATABASE     z   CREATE DATABASE project WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_India.1252';
    DROP DATABASE project;
                     postgres    false            �            1259    16549    branch_admin    TABLE     �  CREATE TABLE public.branch_admin (
    id integer NOT NULL,
    branch_code character varying(50),
    dept_code character varying(50),
    branch_name character varying(100),
    officer_name character varying(100),
    designation character varying(50),
    district character varying(50),
    email character varying(100),
    phone character varying(20),
    username character varying(50),
    password character varying(255)
);
     DROP TABLE public.branch_admin;
       public         heap r       postgres    false            �            1259    16548    branch_admin_id_seq    SEQUENCE     �   CREATE SEQUENCE public.branch_admin_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.branch_admin_id_seq;
       public               postgres    false    224                       0    0    branch_admin_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.branch_admin_id_seq OWNED BY public.branch_admin.id;
          public               postgres    false    223            f           2604    16552    branch_admin id    DEFAULT     r   ALTER TABLE ONLY public.branch_admin ALTER COLUMN id SET DEFAULT nextval('public.branch_admin_id_seq'::regclass);
 >   ALTER TABLE public.branch_admin ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    223    224    224            �          0    16549    branch_admin 
   TABLE DATA           �   COPY public.branch_admin (id, branch_code, dept_code, branch_name, officer_name, designation, district, email, phone, username, password) FROM stdin;
    public               postgres    false    224   �                  0    0    branch_admin_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.branch_admin_id_seq', 1, false);
          public               postgres    false    223            h           2606    16556    branch_admin branch_admin_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.branch_admin
    ADD CONSTRAINT branch_admin_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.branch_admin DROP CONSTRAINT branch_admin_pkey;
       public                 postgres    false    224            �      x������ � �     