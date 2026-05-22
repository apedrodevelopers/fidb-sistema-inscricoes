# 📋 Sistema de Inscrições — FIDB

## 📖 Sobre o projeto

Este repositório contém o **Sistema de Inscrições da FIDB**, desenvolvido como parte da **Formação Inicial de Desenvolvimento Backend**.

O sistema permite gerir inscrições em cursos de formação, com uma **área pública** para formandos e uma **área administrativa protegida por sessão** para administradores.

A aplicação suporta dois tipos de utilizadores:

- **Formando** — acede à área pública para se inscrever em cursos e consultar o comprovativo
- **Administrador** — acede ao painel de administração para gerir cursos, formandos, inscrições e utilizadores

---

## 🎯 Objetivo do projeto

Implementar um **sistema completo de inscrições em cursos**, utilizando **PHP, MySQL e sessões**.

Este projeto tem como objetivo praticar:

- Manipulação de dados com **arrays** e **base de dados relacional**
- Uso de **formulários HTML** e **superglobais** (`$_POST`, `$_GET`, `$_SESSION`)
- Autenticação e **proteção de sessão** na área administrativa
- Organização modular com separação entre **área pública**, **área admin** e **includes partilhados**
- Consultas MySQL com **4 tabelas e 3 views**

---

## 🖥️ Interface da aplicação

![Interface da aplicação](_assets/public.png)

### Área Pública — `publico/` (HTML + CSS + PHP)

Acessível ao **Formando**, sem autenticação:

| Página             | Descrição                           |
| ------------------ | ----------------------------------- |
| `inicio.php`       | Página inicial do sistema           |
| `cursos.php`       | Listagem dos cursos disponíveis     |
| `inscricao.php`    | Formulário de inscrição num curso   |
| `comprovativo.php` | Comprovativo da inscrição realizada |
| `contacto.php`     | Página de contacto                  |

---

### Área Administrativa — `admin/` (PHP + sessão protegida)

![Interface da aplicação](_assets/private.png)

Acessível apenas ao **Administrador** autenticado:

| Página / Pasta  | Descrição                                          |
| --------------- | -------------------------------------------------- |
| `entrar.php`    | Login do administrador                             |
| `dashboard.php` | Painel principal com resumo do sistema             |
| `cursos/`       | Gestão de cursos (listar, criar, editar, eliminar) |
| `formandos/`    | Gestão de formandos inscritos                      |
| `utilizadores/` | Gestão de utilizadores administradores             |

---

### Lógica de negócio — `backend/`

Scripts com as funções reutilizáveis, partilhados entre a área pública e a área admin:

| Ficheiro        | Descrição                                         |
| --------------- | ------------------------------------------------- |
| `config.php`    | Configuração e ligação à base de dados MySQL      |
| `curso.php`     | Funções para operações com cursos                 |
| `inscricao.php` | Funções para operações com inscrições             |
| `dashboard.php` | Funções para dados e estatísticas do painel admin |
| `login.php`     | Funções de autenticação do administrador          |
| `logout.php`    | Encerramento de sessão                            |
| `usuario.php`   | Funções para gestão de utilizadores               |

---

## 🗄️ Base de dados

**Nome:** `bd_inscricoes`  
**Motor:** MySQL — 4 tabelas · 3 views

### Modelo lógico

#### Tabela `cursos`

| Campo          | Tipo          |
| -------------- | ------------- |
| id             | int (PK)      |
| emoji          | varchar(20)   |
| nome           | varchar(150)  |
| subtitulo      | varchar(200)  |
| area           | varchar(100)  |
| duracao        | varchar(30)   |
| modalidade     | enum          |
| vagas          | int           |
| estado         | enum          |
| inicio         | date          |
| horario        | varchar(60)   |
| preco          | decimal(10,2) |
| criado_em      | timestamp     |
| actualizado_em | timestamp     |

#### Tabela `formandos`

| Campo           | Tipo                  |
| --------------- | --------------------- |
| id              | int (PK)              |
| nome            | varchar(150)          |
| email           | varchar(150) (unique) |
| telefone        | varchar(30)           |
| documento       | varchar(40) (unique)  |
| data_nascimento | date                  |
| escolaridade    | varchar(60)           |
| morada          | varchar(200)          |
| criado_em       | timestamp             |
| actualizado_em  | timestamp             |

#### Tabela `inscricoes`

| Campo            | Tipo                 |
| ---------------- | -------------------- |
| id               | int (PK)             |
| numero_inscricao | varchar(20) (unique) |
| formando_id      | int (FK → formandos) |
| curso_id         | int (FK → cursos)    |
| estado           | enum                 |
| criado_em        | timestamp            |
| actualizado_em   | timestamp            |

> Index composto: `formando_id, curso_id`

#### Tabela `utilizadores`

| Campo           | Tipo                  |
| --------------- | --------------------- |
| id              | int (PK)              |
| nome            | varchar(150)          |
| email           | varchar(150) (unique) |
| nome_utilizador | varchar(60) (unique)  |
| senha_hash      | varchar(255)          |
| telefone        | varchar(30)           |
| cargo           | varchar(100)          |
| perfil          | enum                  |
| estado          | enum                  |
| criado_em       | timestamp             |
| actualizado_em  | timestamp             |

---

## 📁 Estrutura do projeto

```
fidb-sistema-inscricoes/
│
├── inicio.php
│
├── paginas/                # Páginas da área pública
│   ├── cursos.php
│   ├── inscricao.php
│   ├── comprovativo.php
│   └── contacto.php
│
├── admin/                  # Área administrativa (sessão protegida)
│   ├── entrar.php
│   ├── dashboard.php
│   ├── cursos/
│   ├── formandos/
│   └── utilizadores/
│
├── backend/                # Lógica de negócio (funções reutilizáveis)
│   ├── config.php
│   ├── curso.php
│   ├── inscricao.php
│   ├── dashboard.php
│   ├── login.php
│   ├── logout.php
│   └── usuario.php
│
├── css/
│
└── _assets/
```

---

## ⚙️ Funcionalidades

### ✍️ Inscrição em curso (Formando)

- Preencher formulário com dados pessoais
- Selecionar o curso pretendido
- Receber número de inscrição único
- Consultar comprovativo da inscrição

### 🔐 Autenticação (Administrador)

- Login com `nome_utilizador` e `senha_hash`
- Sessão protegida em toda a área admin
- Redirecionamento automático se não autenticado

### 📋 Gestão de cursos (Admin)

- Listar, criar, editar e eliminar cursos
- Controlar vagas, estado, modalidade e preço

### 👤 Gestão de formandos (Admin)

- Consultar formandos registados
- Ver inscrições associadas a cada formando

### 📑 Gestão de inscrições (Admin)

- Listar todas as inscrições
- Alterar estado de cada inscrição

### 👥 Gestão de utilizadores (Admin)

- Criar e gerir contas de administradores
- Definir perfil e estado de cada utilizador

---

## 📌 Regras do projeto

- ✔️ PHP puro, sem frameworks
- ✔️ Base de dados **MySQL** com modelo relacional
- ✔️ Sessões PHP para autenticação da área admin
- ✔️ Código organizado por **responsabilidade**
- ✔️ Includes partilhados entre área pública e admin
- ✔️ Validação de dados nos formulários

---

## 🚀 Como executar

1. Clonar o repositório:

```bash
git clone https://github.com/apedrodevelopers/fidb-sistema-inscricoes.git
```

2. Criar a base de dados MySQL com o nome `bd_inscricoes` e importar o script SQL do projeto.

3. Configurar as credenciais da base de dados em `backend/config.php`.

4. Colocar o projeto numa pasta servida pelo PHP (ex: `htdocs` no XAMPP).

5. Aceder no browser:

```
http://localhost/fidb-sistema-inscricoes/inicio.php
```

---

## 👨‍💻 Tecnologias utilizadas

- PHP
- MySQL
- HTML + CSS
- Sessões PHP

---

## 👤 Autor

**Capacita - CFTI**  
[capacitacfti.apedrodevelopers.ao](https://capacitacfti.apedrodevelopers.ao)
