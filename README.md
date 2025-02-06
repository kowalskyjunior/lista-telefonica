# 📞 Projeto Lista Telefônica  

Um sistema web de lista telefônica que permite cadastrar usuários, visualizar seus contatos e adicionar outros usuários como contatos.  

## 🚀 Funcionalidades  

✅ **CRUD de Usuários**: Criar, listar, editar e excluir usuários.  
✅ **Gerenciamento de Contatos**:  
   - Clicar no nome do usuário para abrir uma modal com seus detalhes.  
   - Adicionar outros usuários como contatos.  
   - Remover contatos da lista.  
✅ **Interface Dinâmica** com Bootstrap e jQuery AJAX.  

## 🛠️ Tecnologias Utilizadas  

- **PHP** (Back-end e banco de dados)  
- **MySQL** (Armazenamento de usuários e contatos)  
- **Bootstrap** (Estilização e responsividade)  
- **jQuery + AJAX** (Interatividade sem recarregar a página)  

## 📂 Estrutura do Banco de Dados  

### Tabela `usuarios`  
```sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL
);
