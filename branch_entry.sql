PGDMP          
            }            project    17.5    17.5     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            �           1262    16461    project    DATABASE     z   CREATE DATABASE project WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_India.1252';
    DROP DATABASE project;
                     postgres    false            �            1259    16539    branch_entry    TABLE     �  CREATE TABLE public.branch_entry (
    id integer NOT NULL,
    branchcode character varying(50),
    deptcode character varying(50),
    branch_type character varying(20),
    branch_name character varying(100),
    beeocode character varying(50),
    officer_name character varying(100),
    officer_designation character varying(50),
    office_email character varying(100),
    office_phone character varying(20),
    office_address text
);
     DROP TABLE public.branch_entry;
       public         heap r       postgres    false            �            1259    16538    branch_entry_id_seq    SEQUENCE     �   CREATE SEQUENCE public.branch_entry_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.branch_entry_id_seq;
       public               postgres    false    223            �           0    0    branch_entry_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.branch_entry_id_seq OWNED BY public.branch_entry.id;
          public               postgres    false    222            a           2604    16542    branch_entry id    DEFAULT     r   ALTER TABLE ONLY public.branch_entry ALTER COLUMN id SET DEFAULT nextval('public.branch_entry_id_seq'::regclass);
 >   ALTER TABLE public.branch_entry ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    223    222    223            �          0    16539    branch_entry 
   TABLE DATA           �   COPY public.branch_entry (id, branchcode, deptcode, branch_type, branch_name, beeocode, officer_name, officer_designation, office_email, office_phone, office_address) FROM stdin;
    public               postgres    false    223   �       �           0    0    branch_entry_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.branch_entry_id_seq', 1, false);
          public               postgres    false    222            c           2606    16546    branch_entry branch_entry_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.branch_entry
    ADD CONSTRAINT branch_entry_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.branch_entry DROP CONSTRAINT branch_entry_pkey;
       public                 postgres    false    223            �      x������ � �     