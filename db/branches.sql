PGDMP  8                    }            PROJECT    17.5    17.5     '           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            (           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            )           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            *           1262    16567    PROJECT    DATABASE     |   CREATE DATABASE "PROJECT" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_India.1252';
    DROP DATABASE "PROJECT";
                     postgres    false            �            1259    16749    branches    TABLE     �  CREATE TABLE public.branches (
    id integer NOT NULL,
    branchcode character varying(20) NOT NULL,
    deptcode character varying(20) NOT NULL,
    branch_type character varying(50) NOT NULL,
    branch_lac character varying(50) NOT NULL,
    branch_name character varying(100) NOT NULL,
    address text NOT NULL,
    beeocode character varying(20) NOT NULL,
    head character varying(100) NOT NULL
);
    DROP TABLE public.branches;
       public         heap r       postgres    false            �            1259    16748    branches_id_seq    SEQUENCE     �   CREATE SEQUENCE public.branches_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.branches_id_seq;
       public               postgres    false    228            +           0    0    branches_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.branches_id_seq OWNED BY public.branches.id;
          public               postgres    false    227            �           2604    16752    branches id    DEFAULT     j   ALTER TABLE ONLY public.branches ALTER COLUMN id SET DEFAULT nextval('public.branches_id_seq'::regclass);
 :   ALTER TABLE public.branches ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    228    227    228            $          0    16749    branches 
   TABLE DATA           {   COPY public.branches (id, branchcode, deptcode, branch_type, branch_lac, branch_name, address, beeocode, head) FROM stdin;
    public               postgres    false    228   �       ,           0    0    branches_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.branches_id_seq', 1, true);
          public               postgres    false    227            �           2606    16756    branches branches_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.branches
    ADD CONSTRAINT branches_pkey PRIMARY KEY (branchcode);
 @   ALTER TABLE ONLY public.branches DROP CONSTRAINT branches_pkey;
       public                 postgres    false    228            �           2606    16757    branches branches_deptcode_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.branches
    ADD CONSTRAINT branches_deptcode_fkey FOREIGN KEY (deptcode) REFERENCES public.dept_entry(dept_code) ON UPDATE CASCADE ON DELETE CASCADE;
 I   ALTER TABLE ONLY public.branches DROP CONSTRAINT branches_deptcode_fkey;
       public               postgres    false    228            $   V   x�3�44000�����>�����E�.��%E��%
������ř�y�E
�ii�ɩ�~�E%
����)
���%�E\1z\\\ ���     