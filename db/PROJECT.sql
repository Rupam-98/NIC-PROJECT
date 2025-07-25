PGDMP  *                    }            PROJECT    17.5    17.5 4    O           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            P           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            Q           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            R           1262    16429    PROJECT    DATABASE     �   CREATE DATABASE "PROJECT" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE "PROJECT";
                     postgres    false                        3079    16499    pgcrypto 	   EXTENSION     <   CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;
    DROP EXTENSION pgcrypto;
                        false            S           0    0    EXTENSION pgcrypto    COMMENT     <   COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';
                             false    2            �            1259    16442    branches    TABLE     �   CREATE TABLE public.branches (
    d_code integer NOT NULL,
    d_name character varying NOT NULL,
    b_code integer NOT NULL,
    b_type character varying NOT NULL,
    b_name character varying NOT NULL,
    b_address character varying NOT NULL
);
    DROP TABLE public.branches;
       public         heap r       postgres    false            �            1259    16441    branches_b_code_seq    SEQUENCE     �   CREATE SEQUENCE public.branches_b_code_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.branches_b_code_seq;
       public               postgres    false    222            T           0    0    branches_b_code_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.branches_b_code_seq OWNED BY public.branches.b_code;
          public               postgres    false    221            �            1259    16440    branches_d_code_seq    SEQUENCE     �   CREATE SEQUENCE public.branches_d_code_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.branches_d_code_seq;
       public               postgres    false    222            U           0    0    branches_d_code_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.branches_d_code_seq OWNED BY public.branches.d_code;
          public               postgres    false    220            �            1259    16431    departments    TABLE     /  CREATE TABLE public.departments (
    d_code integer NOT NULL,
    "d-type" character varying NOT NULL,
    d_cons character varying NOT NULL,
    d_name character varying NOT NULL,
    address character varying NOT NULL,
    beeo_code numeric DEFAULT 0 NOT NULL,
    head character varying NOT NULL
);
    DROP TABLE public.departments;
       public         heap r       postgres    false            �            1259    16430    departments_d_code_seq    SEQUENCE     �   CREATE SEQUENCE public.departments_d_code_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.departments_d_code_seq;
       public               postgres    false    219            V           0    0    departments_d_code_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.departments_d_code_seq OWNED BY public.departments.d_code;
          public               postgres    false    218            �            1259    16563    dept_admins    TABLE     �  CREATE TABLE public.dept_admins (
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
       public         heap r       postgres    false            �            1259    16568    dept_admins_id_seq    SEQUENCE     �   CREATE SEQUENCE public.dept_admins_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.dept_admins_id_seq;
       public               postgres    false    227            W           0    0    dept_admins_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.dept_admins_id_seq OWNED BY public.dept_admins.id;
          public               postgres    false    228            �            1259    16542 
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
       public         heap r       postgres    false            �            1259    16541    dept_entry_id_seq    SEQUENCE     �   CREATE SEQUENCE public.dept_entry_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.dept_entry_id_seq;
       public               postgres    false    226            X           0    0    dept_entry_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.dept_entry_id_seq OWNED BY public.dept_entry.id;
          public               postgres    false    225            �            1259    16588 	   employees    TABLE       CREATE TABLE public.employees (
    slno integer NOT NULL,
    depcode character varying(20) NOT NULL,
    department character varying(100) NOT NULL,
    branch_code character varying(20) NOT NULL,
    branch_address character varying(255) NOT NULL,
    name character varying(100) NOT NULL,
    desig character varying(100) NOT NULL,
    sex character varying(10) NOT NULL,
    age integer NOT NULL,
    epic character varying(50) NOT NULL,
    phone character varying(15) NOT NULL,
    home_lac character varying(100) NOT NULL,
    residential_lac character varying(100) NOT NULL,
    branch_lac character varying(100) NOT NULL,
    beeo_code character varying(20) NOT NULL,
    basic character varying(100) NOT NULL,
    gazeted boolean NOT NULL,
    remarks text NOT NULL,
    education character varying(100) NOT NULL,
    dor date NOT NULL,
    ac_no numeric(30,0) NOT NULL,
    ifsc_code character varying(20) NOT NULL,
    branch_name character varying(100) NOT NULL,
    bank_branch_address character varying(255) NOT NULL
);
    DROP TABLE public.employees;
       public         heap r       postgres    false            �            1259    16452    systemlogin    TABLE       CREATE TABLE public.systemlogin (
    id integer NOT NULL,
    full_name character varying(100),
    gender character varying(10),
    dob date,
    username character varying(100),
    phone_number character varying(20),
    password text,
    admin_type character varying(100)
);
    DROP TABLE public.systemlogin;
       public         heap r       postgres    false            �            1259    16451    students_id_seq    SEQUENCE     �   CREATE SEQUENCE public.students_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.students_id_seq;
       public               postgres    false    224            Y           0    0    students_id_seq    SEQUENCE OWNED BY     F   ALTER SEQUENCE public.students_id_seq OWNED BY public.systemlogin.id;
          public               postgres    false    223            �           2604    16445    branches d_code    DEFAULT     r   ALTER TABLE ONLY public.branches ALTER COLUMN d_code SET DEFAULT nextval('public.branches_d_code_seq'::regclass);
 >   ALTER TABLE public.branches ALTER COLUMN d_code DROP DEFAULT;
       public               postgres    false    222    220    222            �           2604    16446    branches b_code    DEFAULT     r   ALTER TABLE ONLY public.branches ALTER COLUMN b_code SET DEFAULT nextval('public.branches_b_code_seq'::regclass);
 >   ALTER TABLE public.branches ALTER COLUMN b_code DROP DEFAULT;
       public               postgres    false    221    222    222            �           2604    16434    departments d_code    DEFAULT     x   ALTER TABLE ONLY public.departments ALTER COLUMN d_code SET DEFAULT nextval('public.departments_d_code_seq'::regclass);
 A   ALTER TABLE public.departments ALTER COLUMN d_code DROP DEFAULT;
       public               postgres    false    219    218    219            �           2604    16569    dept_admins id    DEFAULT     p   ALTER TABLE ONLY public.dept_admins ALTER COLUMN id SET DEFAULT nextval('public.dept_admins_id_seq'::regclass);
 =   ALTER TABLE public.dept_admins ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    228    227            �           2604    16545    dept_entry id    DEFAULT     n   ALTER TABLE ONLY public.dept_entry ALTER COLUMN id SET DEFAULT nextval('public.dept_entry_id_seq'::regclass);
 <   ALTER TABLE public.dept_entry ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    225    226    226            �           2604    16455    systemlogin id    DEFAULT     m   ALTER TABLE ONLY public.systemlogin ALTER COLUMN id SET DEFAULT nextval('public.students_id_seq'::regclass);
 =   ALTER TABLE public.systemlogin ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    224    223    224            E          0    16442    branches 
   TABLE DATA           U   COPY public.branches (d_code, d_name, b_code, b_type, b_name, b_address) FROM stdin;
    public               postgres    false    222   sA       B          0    16431    departments 
   TABLE DATA           a   COPY public.departments (d_code, "d-type", d_cons, d_name, address, beeo_code, head) FROM stdin;
    public               postgres    false    219   �A       J          0    16563    dept_admins 
   TABLE DATA           �   COPY public.dept_admins (id, dept_code, dept_name, officer_name, designation, district, email, phone, username, password) FROM stdin;
    public               postgres    false    227   �A       I          0    16542 
   dept_entry 
   TABLE DATA           �   COPY public.dept_entry (id, dept_type, dept_code, dept_name, officer_name, officer_designation, office_email, office_phone, office_address) FROM stdin;
    public               postgres    false    226   bB       L          0    16588 	   employees 
   TABLE DATA             COPY public.employees (slno, depcode, department, branch_code, branch_address, name, desig, sex, age, epic, phone, home_lac, residential_lac, branch_lac, beeo_code, basic, gazeted, remarks, education, dor, ac_no, ifsc_code, branch_name, bank_branch_address) FROM stdin;
    public               postgres    false    229   �B       G          0    16452    systemlogin 
   TABLE DATA           o   COPY public.systemlogin (id, full_name, gender, dob, username, phone_number, password, admin_type) FROM stdin;
    public               postgres    false    224   �C       Z           0    0    branches_b_code_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.branches_b_code_seq', 1, false);
          public               postgres    false    221            [           0    0    branches_d_code_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.branches_d_code_seq', 1, false);
          public               postgres    false    220            \           0    0    departments_d_code_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.departments_d_code_seq', 1, false);
          public               postgres    false    218            ]           0    0    dept_admins_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.dept_admins_id_seq', 2, true);
          public               postgres    false    228            ^           0    0    dept_entry_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.dept_entry_id_seq', 1, true);
          public               postgres    false    225            _           0    0    students_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.students_id_seq', 3, true);
          public               postgres    false    223            �           2606    16450    branches branches_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.branches
    ADD CONSTRAINT branches_pkey PRIMARY KEY (b_code);
 @   ALTER TABLE ONLY public.branches DROP CONSTRAINT branches_pkey;
       public                 postgres    false    222            �           2606    16439    departments departments_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.departments
    ADD CONSTRAINT departments_pkey PRIMARY KEY (d_code);
 F   ALTER TABLE ONLY public.departments DROP CONSTRAINT departments_pkey;
       public                 postgres    false    219            �           2606    16571    dept_admins dept_admins_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.dept_admins
    ADD CONSTRAINT dept_admins_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.dept_admins DROP CONSTRAINT dept_admins_pkey;
       public                 postgres    false    227            �           2606    16549    dept_entry dept_entry_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.dept_entry
    ADD CONSTRAINT dept_entry_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.dept_entry DROP CONSTRAINT dept_entry_pkey;
       public                 postgres    false    226            �           2606    16600    employees employees_ac_no_key 
   CONSTRAINT     Y   ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_ac_no_key UNIQUE (ac_no);
 G   ALTER TABLE ONLY public.employees DROP CONSTRAINT employees_ac_no_key;
       public                 postgres    false    229            �           2606    16596    employees employees_epic_key 
   CONSTRAINT     W   ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_epic_key UNIQUE (epic);
 F   ALTER TABLE ONLY public.employees DROP CONSTRAINT employees_epic_key;
       public                 postgres    false    229            �           2606    16598    employees employees_phone_key 
   CONSTRAINT     Y   ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_phone_key UNIQUE (phone);
 G   ALTER TABLE ONLY public.employees DROP CONSTRAINT employees_phone_key;
       public                 postgres    false    229            �           2606    16594    employees employees_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_pkey PRIMARY KEY (slno);
 B   ALTER TABLE ONLY public.employees DROP CONSTRAINT employees_pkey;
       public                 postgres    false    229            �           2606    16459    systemlogin students_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY public.systemlogin
    ADD CONSTRAINT students_pkey PRIMARY KEY (id);
 C   ALTER TABLE ONLY public.systemlogin DROP CONSTRAINT students_pkey;
       public                 postgres    false    224            �           2606    16461 !   systemlogin students_username_key 
   CONSTRAINT     `   ALTER TABLE ONLY public.systemlogin
    ADD CONSTRAINT students_username_key UNIQUE (username);
 K   ALTER TABLE ONLY public.systemlogin DROP CONSTRAINT students_username_key;
       public                 postgres    false    224            E      x������ � �      B      x������ � �      J   �   x�5ɻ�0 �����m���	*	���R�^�T��uq;��9D4�����Z)�}eXV�TTp4��F�2g[�N�z�!�"He{#��t���FI�B+����=�~��m��e7is�r?ټ����ip��>~Շu��$h�����L�Ա��eY_u7�      I   }   x�5��
�0 �s����q��v�R����E�(���|���h=��cQ���)'Ý�̥�,�b;�z���;��'�/��8��_o}$���y�I2���@�U]�E�F<���y���)�      L   �   x�e���0���S����8�3HTLtu�X�BM[�߲�p�r�|9G��yK�g��&r�̬-��=uz%��vQ�@�w�Px�iqN��쵝�>��L�\"J8�TfR�|�h�y��Y�"�r�PW�!����'q0�y&q�e�rD!�FQ��ݨ����sE�/H      G   �   x�3��H,�T((J,N��KTH�/J���M�I�4200�50�5��q���470024�017�T1�T14PI)�,�q���rI�r��
���p1O�p/�L6-��
�s6̶H���+�3��,�,.I͍OL�������� t�'     