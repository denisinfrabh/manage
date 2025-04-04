# Manage - Gerenciador de Arquivos

E aí, sô! Bem-vindo ao **Manage**, um sistema simples e bão pra gerenciar arquivos de clientes, feito com PHP puro e um tiquim de mineirice. Aqui o admin manda ver cadastrando usuários e subindo arquivos, enquanto o usuário só dá uma espiada nos seus documentos. Tudo organizado, versionado com Git e hospedado no GitHub pra ficar zoeira de bão!

## Funcionalidades
- **Login**: Admin e usuários entram com usuário e senha (hash seguro, sô!).
- **Admin**: 
  - Cadastra novos usuários (CPF ou CNPJ, tudo validado).
  - Envia arquivos pras pastas dos clientes (sem sobrescrever, renomeia direitinho).
  - Apaga arquivos e lista só as pastas registradas no banco.
- **Usuário**: Vê os arquivos da sua pasta e sai quando quiser.
- **Banco**: MySQL com `manage_files`, guardadinho no `db.sql`.

## Estrutura
~~~
manage/
├── public_html/
│   ├── public/
│   ├── src/
│   │   ├── config.php
│   │   ├── funcoes.php
│   │   └── gerar_hash.php  # Novo aqui
│   ├── clientes/
│   │   └── .gitkeep
│   ├── db.sql
│   ├── .gitignore
│   └── readme.md
~~~

## Como rodar
1. Instala o Laragon (ou outro servidor PHP/MySQL).
2. Joga tudo na pasta `C:\laragon\www\manage`.
3. Cria o banco com o `db.sql`.
4. Acessa `manage.test` e manda ver!

## Git e GitHub
- Versionado com Git, direto do terminal do Laragon.
- Repositório: [github.com/denisinfrabh/manage](https://github.com/denisinfrabh/manage).
- Commits organizadinhos, pra voltar atrás se der treta.

## Próximos passos
- Bootstrap pra deixar bonitão, com modais pra cadastrar e enviar.
- Mais validações no cadastro, pra não dar zoeira.
- Mais validações no cadastro, pra não dar zoeira. linha de teste

Feito com carinho por um bichão mineiro e um poeta digital, sô! Qualquer coisa, dá um grito que a gente desenrola!