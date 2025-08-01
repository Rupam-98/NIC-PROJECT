PGDMP                      }            PROJECT    17.5    17.5 >    j           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            k           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            l           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            m           1262    16429    PROJECT    DATABASE     �   CREATE DATABASE "PROJECT" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE "PROJECT";
                     postgres    false                        3079    16499    pgcrypto 	   EXTENSION     <   CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;
    DROP EXTENSION pgcrypto;
                        false            n           0    0    EXTENSION pgcrypto    COMMENT     <   COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';
                             false    2            �            1259    16710    admins    TABLE     �  CREATE TABLE public.admins (
    id integer NOT NULL,
    username text NOT NULL,
    password text NOT NULL,
    role text NOT NULL,
    dept_code integer,
    branch_code integer,
    dept_name text,
    branch_name text,
    officer_name text NOT NULL,
    designation text NOT NULL,
    district text NOT NULL,
    email text NOT NULL,
    phone text NOT NULL,
    CONSTRAINT admins_role_check CHECK ((role = ANY (ARRAY['super_admin'::text, 'department_admin'::text, 'branch_admin'::text])))
);
    DROP TABLE public.admins;
       public         heap r       postgres    false            �            1259    16709    admins_id_seq    SEQUENCE     �   CREATE SEQUENCE public.admins_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.admins_id_seq;
       public               postgres    false    231            o           0    0    admins_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.admins_id_seq OWNED BY public.admins.id;
          public               postgres    false    230            �            1259    16670    branch    TABLE     `   CREATE TABLE public.branch (
    branch_code integer NOT NULL,
    branch_name text NOT NULL
);
    DROP TABLE public.branch;
       public         heap r       postgres    false            �            1259    16601    branch_admins    TABLE       CREATE TABLE public.branch_admins (
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
       public         heap r       postgres    false            �            1259    16606    branch_admins_id_seq    SEQUENCE     �   CREATE SEQUENCE public.branch_admins_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.branch_admins_id_seq;
       public               postgres    false    223            p           0    0    branch_admins_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.branch_admins_id_seq OWNED BY public.branch_admins.id;
          public               postgres    false    224            �            1259    16634    branches    TABLE     �  CREATE TABLE public.branches (
    id integer NOT NULL,
    branch_code integer NOT NULL,
    dept_code character varying NOT NULL,
    branch_type character varying(50) NOT NULL,
    branch_lac character varying(50) NOT NULL,
    branch_name character varying(100) NOT NULL,
    address text NOT NULL,
    beeocode character varying(20) NOT NULL,
    head character varying(100) NOT NULL
);
    DROP TABLE public.branches;
       public         heap r       postgres    false            �            1259    16639    branches_id_seq    SEQUENCE     �   CREATE SEQUENCE public.branches_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.branches_id_seq;
       public               postgres    false    226            q           0    0    branches_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.branches_id_seq OWNED BY public.branches.id;
          public               postgres    false    227            �            1259    16663 
   department    TABLE     j   CREATE TABLE public.department (
    dept_code character varying NOT NULL,
    dept_name text NOT NULL
);
    DROP TABLE public.department;
       public         heap r       postgres    false            �            1259    16563    dept_admins    TABLE     �  CREATE TABLE public.dept_admins (
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
       public               postgres    false    220            r           0    0    dept_admins_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.dept_admins_id_seq OWNED BY public.dept_admins.id;
          public               postgres    false    221            �            1259    16625 
   dept_entry    TABLE     �   CREATE TABLE public.dept_entry (
    dept_type character varying(100) NOT NULL,
    dept_code character varying(10) NOT NULL,
    dept_name character varying(100) NOT NULL,
    address text NOT NULL,
    head character varying(100) NOT NULL
);
    DROP TABLE public.dept_entry;
       public         heap r       postgres    false            �            1259    16588 	   employees    TABLE       CREATE TABLE public.employees (
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
       public               postgres    false    219            s           0    0    students_id_seq    SEQUENCE OWNED BY     F   ALTER SEQUENCE public.students_id_seq OWNED BY public.systemlogin.id;
          public               postgres    false    218            �           2604    16713 	   admins id    DEFAULT     f   ALTER TABLE ONLY public.admins ALTER COLUMN id SET DEFAULT nextval('public.admins_id_seq'::regclass);
 8   ALTER TABLE public.admins ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    231    230    231            �           2604    16607    branch_admins id    DEFAULT     t   ALTER TABLE ONLY public.branch_admins ALTER COLUMN id SET DEFAULT nextval('public.branch_admins_id_seq'::regclass);
 ?   ALTER TABLE public.branch_admins ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    224    223            �           2604    16640    branches id    DEFAULT     j   ALTER TABLE ONLY public.branches ALTER COLUMN id SET DEFAULT nextval('public.branches_id_seq'::regclass);
 :   ALTER TABLE public.branches ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    227    226            �           2604    16569    dept_admins id    DEFAULT     p   ALTER TABLE ONLY public.dept_admins ALTER COLUMN id SET DEFAULT nextval('public.dept_admins_id_seq'::regclass);
 =   ALTER TABLE public.dept_admins ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    221    220            �           2604    16455    systemlogin id    DEFAULT     m   ALTER TABLE ONLY public.systemlogin ALTER COLUMN id SET DEFAULT nextval('public.students_id_seq'::regclass);
 =   ALTER TABLE public.systemlogin ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    219    218    219            g          0    16710    admins 
   TABLE DATA           �   COPY public.admins (id, username, password, role, dept_code, branch_code, dept_name, branch_name, officer_name, designation, district, email, phone) FROM stdin;
    public               postgres    false    231   �O       e          0    16670    branch 
   TABLE DATA           :   COPY public.branch (branch_code, branch_name) FROM stdin;
    public               postgres    false    229   xR       _          0    16601    branch_admins 
   TABLE DATA           �   COPY public.branch_admins (id, branch_code, dept_code, branch_name, officer_name, designation, district, email, phone, username, password) FROM stdin;
    public               postgres    false    223   �R       b          0    16634    branches 
   TABLE DATA           }   COPY public.branches (id, branch_code, dept_code, branch_type, branch_lac, branch_name, address, beeocode, head) FROM stdin;
    public               postgres    false    226   �S       d          0    16663 
   department 
   TABLE DATA           :   COPY public.department (dept_code, dept_name) FROM stdin;
    public               postgres    false    228   YT       \          0    16563    dept_admins 
   TABLE DATA           �   COPY public.dept_admins (id, dept_code, dept_name, officer_name, designation, district, email, phone, username, password) FROM stdin;
    public               postgres    false    220   �T       a          0    16625 
   dept_entry 
   TABLE DATA           T   COPY public.dept_entry (dept_type, dept_code, dept_name, address, head) FROM stdin;
    public               postgres    false    225   dU       ^          0    16588 	   employees 
   TABLE DATA             COPY public.employees (slno, depcode, department, branch_code, branch_address, name, desig, sex, age, epic, phone, home_lac, residential_lac, branch_lac, beeo_code, basic, gazeted, remarks, education, dor, ac_no, ifsc_code, branch_name, bank_branch_address) FROM stdin;
    public               postgres    false    222   V       [          0    16452    systemlogin 
   TABLE DATA           o   COPY public.systemlogin (id, full_name, gender, dob, username, phone_number, password, admin_type) FROM stdin;
    public               postgres    false    219   �W       t           0    0    admins_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.admins_id_seq', 13, true);
          public               postgres    false    230            u           0    0    branch_admins_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.branch_admins_id_seq', 8, true);
          public               postgres    false    224            v           0    0    branches_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.branches_id_seq', 6, true);
          public               postgres    false    227            w           0    0    dept_admins_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.dept_admins_id_seq', 2, true);
          public               postgres    false    221            x           0    0    students_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.students_id_seq', 3, true);
          public               postgres    false    218            �           2606    16722    admins admins_email_key 
   CONSTRAINT     S   ALTER TABLE ONLY public.admins
    ADD CONSTRAINT admins_email_key UNIQUE (email);
 A   ALTER TABLE ONLY public.admins DROP CONSTRAINT admins_email_key;
       public                 postgres    false    231            �           2606    16724    admins admins_phone_key 
   CONSTRAINT     S   ALTER TABLE ONLY public.admins
    ADD CONSTRAINT admins_phone_key UNIQUE (phone);
 A   ALTER TABLE ONLY public.admins DROP CONSTRAINT admins_phone_key;
       public                 postgres    false    231            �           2606    16718    admins admins_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.admins
    ADD CONSTRAINT admins_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.admins DROP CONSTRAINT admins_pkey;
       public                 postgres    false    231            �           2606    16720    admins admins_username_key 
   CONSTRAINT     Y   ALTER TABLE ONLY public.admins
    ADD CONSTRAINT admins_username_key UNIQUE (username);
 D   ALTER TABLE ONLY public.admins DROP CONSTRAINT admins_username_key;
       public                 postgres    false    231            �           2606    16609     branch_admins branch_admins_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.branch_admins
    ADD CONSTRAINT branch_admins_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.branch_admins DROP CONSTRAINT branch_admins_pkey;
       public                 postgres    false    223            �           2606    16611 (   branch_admins branch_admins_username_key 
   CONSTRAINT     g   ALTER TABLE ONLY public.branch_admins
    ADD CONSTRAINT branch_admins_username_key UNIQUE (username);
 R   ALTER TABLE ONLY public.branch_admins DROP CONSTRAINT branch_admins_username_key;
       public                 postgres    false    223            �           2606    16676    branch branch_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY public.branch
    ADD CONSTRAINT branch_pkey PRIMARY KEY (branch_code);
 <   ALTER TABLE ONLY public.branch DROP CONSTRAINT branch_pkey;
       public                 postgres    false    229            �           2606    16792    branches branches_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.branches
    ADD CONSTRAINT branches_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.branches DROP CONSTRAINT branches_pkey;
       public                 postgres    false    226            �           2606    16733    department department_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.department
    ADD CONSTRAINT department_pkey PRIMARY KEY (dept_code);
 D   ALTER TABLE ONLY public.department DROP CONSTRAINT department_pkey;
       public                 postgres    false    228            �           2606    16571    dept_admins dept_admins_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.dept_admins
    ADD CONSTRAINT dept_admins_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.dept_admins DROP CONSTRAINT dept_admins_pkey;
       public                 postgres    false    220            �           2606    16633    dept_entry dept_entry_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.dept_entry
    ADD CONSTRAINT dept_entry_pkey PRIMARY KEY (dept_code);
 D   ALTER TABLE ONLY public.dept_entry DROP CONSTRAINT dept_entry_pkey;
       public                 postgres    false    225            �           2606    16600    employees employees_ac_no_key 
   CONSTRAINT     Y   ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_ac_no_key UNIQUE (ac_no);
 G   ALTER TABLE ONLY public.employees DROP CONSTRAINT employees_ac_no_key;
       public                 postgres    false    222            �           2606    16596    employees employees_epic_key 
   CONSTRAINT     W   ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_epic_key UNIQUE (epic);
 F   ALTER TABLE ONLY public.employees DROP CONSTRAINT employees_epic_key;
       public                 postgres    false    222            �           2606    16598    employees employees_phone_key 
   CONSTRAINT     Y   ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_phone_key UNIQUE (phone);
 G   ALTER TABLE ONLY public.employees DROP CONSTRAINT employees_phone_key;
       public                 postgres    false    222            �           2606    16594    employees employees_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_pkey PRIMARY KEY (slno);
 B   ALTER TABLE ONLY public.employees DROP CONSTRAINT employees_pkey;
       public                 postgres    false    222            �           2606    16459    systemlogin students_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY public.systemlogin
    ADD CONSTRAINT students_pkey PRIMARY KEY (id);
 C   ALTER TABLE ONLY public.systemlogin DROP CONSTRAINT students_pkey;
       public                 postgres    false    219            �           2606    16461 !   systemlogin students_username_key 
   CONSTRAINT     `   ALTER TABLE ONLY public.systemlogin
    ADD CONSTRAINT students_username_key UNIQUE (username);
 K   ALTER TABLE ONLY public.systemlogin DROP CONSTRAINT students_username_key;
       public                 postgres    false    219            �           2606    16727    branches branches_deptcode_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.branches
    ADD CONSTRAINT branches_deptcode_fkey FOREIGN KEY (dept_code) REFERENCES public.dept_entry(dept_code) ON UPDATE CASCADE ON DELETE CASCADE;
 I   ALTER TABLE ONLY public.branches DROP CONSTRAINT branches_deptcode_fkey;
       public               postgres    false    226    4793    225            g   �  x���]s�<���Wp�cM��l+�H�X?j�ٙwb��J���o��Vww��f2�y��羃.�P,�Nm� �;:�jE����*� `���
�����3�L���/������bR ^1�U����L�  M�1�os���y��=銧�,��'M�!�������۞!��p�$ӱ��nȆ��/:���Ih���[ulG>|�����mO�7>����bd�~.���4��J;����l�Ѳ�yF��v�?\r��y����Jy@��jӔ~��B��: Tl�2e.R?�m��m�Q�l�i8��}��N��v��V�G݅ۄ�ʨ�>͢�f,m9�pr3���v�H���U:/�<���4W����ٙ!;�7��bԎ	�ç�_�>���-���������`�Q�8.Ը�w�YЫ�`�T�?[�9pm�P��P�d���[^�C��*������@.q�ʡ��$JTN�&?M���Y3xH��2J�ޙ�L���G<Q�=^R�'�y��I���8=���)~��4���5i��Ά��43X�x<�L
��׆4���v��g�>�߃�S��>io�� �E�;��</>��g�<�S�y"�#���o�%V"U�"�b�7��P��0�ioS
�v#����y�F��I��l�r��^�B��yϤ�.�%�K|*{_��""�DY��A�Q"-۲"L��^�҅��_�my����d��m�?z�,�Z�      e   ^   x����  �t
&0GЧ��`S���_�s���(�f�jMIJ�9�e߅\Kz3�T��4F><�7S�NIϛ��3q�C�k ��      _   �   x�5ͽ�0@����MK�qT�� 
	C����� >�:��|۱�QJٯ�B��/��qD9T�$��
2�$Ur(J�&���z�0	 .��sR��u�Zد��~�k�s!������Q3<�Tv�i�G�=�╶{g��]��ﮌ��޾���8��N򣟴�2n+�0>�9�      b   �   x�m�K�0��)|�
%E�G� -`cRC,��J��i+D�g3z����B+��@-jq��e�=��pʑM�u�S��R��zeC�
1[��Jl	8b��bt�_4?�
�%��&8G7�&���5ܡ�KQ*U�,�4~H�P��^���<f.�k��UJ�ص;Ϥ�O��U�      d   F   x�3400�t�,.)�L.Qp����,.���K-R�OK�LN�24000��K�O��L�H���ILO����� ���      \   �   x�5ɻ�0 �����m���	*	���R�^�T��uq;��9D4�����Z)�}eXV�TTp4��F�2g[�N�z�!�"He{#��t���FI�B+����=�~��m��e7is�r?ټ����ip��>~Շu��$h�����L�Ա��eY_u7�      a   �   x�M�A�0�u{�9 !�'0�Pc���s3�BGhK��DOo����?��V�EQ��BdR*o-�@�i���Ii�x�8��¢��z�b-��'e0�i҃�%ٟ829E3N	�>/������@�!Nx�����`�v�J��%�簧�l�L#�K.�|�}B�      ^   �  x����r� �ϫ���΂@��Վ�$n&io� E�Hd� �q��]��رo=� ;�|���+	3Xj�8�����0t���������oX��y�z�@d0_��(�2WEYIw����;�ڛ�����M�A �E*J��2W�z�"�#��
���wެ��I,�j3o�@273���γ_��i��9,�=;�;	�ͷ㨍���T�Lɼ$�
���*WB�W%N]��`A���(���*J��q�"�9B]��o٣��7�"��o���ް�y݃���j�XE� �RU<��{ȅ�s�ڭ�޾��"Td��#��S�S�(�0E>e�a�侁vga�۰k)��e����Z����f��ф�W���0!�1h؃w�n�gG��W�3B�t�RU�(r��l�}7lt07gE�L�ʏn=������TTp:����.�\f�� ��1��-I��W      [   �   x���
�0 ���vU���^2ʂʐ���ڴ� �>�;���M4z�F��cO*|i" d"���,�( �!K�$Ľ�jٷh�xv�ORm&|,���^���:]oUu���S�nH�ä�[k�&��{�($     