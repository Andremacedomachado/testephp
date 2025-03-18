# Projeto Simples de Fila de Impressão de Produtos em PHP

## Descrição do Projeto

Este projeto é um teste básico utilizando PHP, abordando conceitos fundamentais como:

* Realização de requisições via formulários.
* Gerenciamento de sessões no PHP.
* Conexão com banco de dados MySQL.
* Programação orientada a objetos (POO) em PHP.
* Utilização de frameworks e dependências gerenciadas pelo Composer.

---

## Requisitos

Para executar este projeto, é necessário ter as seguintes ferramentas instaladas:

* Um ambiente `AMP` de sua preferência (exemplo: [XAMPP](https://www.apachefriends.org/pt_br/download.html), [WAMP](https://www.wampserver.com/en/download-wampserver-64bits/), [MAMP](https://www.mamp.info/en/downloads/)) para hospedar localmente o servidor e utilizar o banco de dados MySQL.
* O `Composer` para instalar as dependências com base no arquivo `composer.json`.([link de referencia](https://getcomposer.org/download/)).

---

## Instalação

Siga os passos abaixo para configurar e rodar o projeto:

### 1. Configuração do Arquivo `.env`

Crie um arquivo `.env` na raiz do projeto e configure as variáveis de ambiente para a conexão com o banco de dados MySQL:

```ini
APIDRIVER=mysql
APIHOST=seu_host
APIDB=nome_do_banco
APICHARSET=utf8
APIUSER=seu_usuario
APIPASSWORD=sua_senha
```

### 2. Configuração do Banco de Dados

Crie um banco de dados MySQL e execute o seguinte script para criar a tabela `products`:

```sql
CREATE TABLE `products` (
  `EAN` BIGINT(13) NOT NULL,
  `codigo_interno` INT(6) NOT NULL,
  `descricao` VARCHAR(200) NOT NULL,
  `imagem` VARCHAR(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE `products`
  ADD PRIMARY KEY (`codigo_interno`);

ALTER TABLE `products`
  MODIFY `codigo_interno` INT(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222223;
COMMIT;
```

### 3. Inserção de Dados no Banco

Para popular a tabela com alguns produtos de exemplo, execute a seguinte consulta SQL:

```sql
INSERT INTO `products` (`EAN`, `codigo_interno`, `descricao`, `imagem`) VALUES
(7894900011517, 1, 'REFRIGERANTE COCA-COLA GARRAFA 2L', 'http://localhost/testephp.com.br/public/7894900011517.jfif'),
(7891000002643, 2, 'LEITE EM PÓ NINHO INSTANTÂNEO', 'http://localhost/testephp.com.br/public/7891000002643.jfif'),
(7896102501995, 3, 'EXTRATO DE TOMATE QUERO EXTRATO+ SACHÊ 300GO', 'http://localhost/testephp.com.br/public/7896102501995.png'),
(7898375930571, 4, 'ALFACE CRESPA', 'http://localhost/testephp.com.br/public/7898375930571.jfif'),
(7896276060021, 5, 'ARROZ AGULHINHA ARROZAL T1 5KG', 'http://localhost/testephp.com.br/public/7896276060021.jfif');
```

### 4. Importação das Imagens dos Produtos  

Para baixar as imagens, acesse o [site da Cosmo Bluesoft](https://cosmos.bluesoft.com.br/produtos) e busque os produtos pelo código `EAN`.  

Em seguida, salve as imagens na pasta `public` do projeto.  

> **Observação:** É necessário criar a pasta `public`, pois ela está listada no `.gitignore` e não será incluída no repositório automaticamente. 

---

Agora seu projeto está pronto para ser executado! 🚀

