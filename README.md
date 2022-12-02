# hiae-laravel-test

### Pontos para melhorias
- Usar UUID no lugar de ID nas rotas
- Confirmar e-mail no cadastro de novos usuários
- Mover domínio da empresa permitido para novos cadastros no .env/config
- Melhorar traduções pt-br ou usar somente en

### Seja muuuuuito bem vindo(a) ao teste para desenvolvedor Laravel.

Gostamos de código;  
Gostamos de café;  
E também gostamos de desafios, portanto tomamos a liberdade de criar este, especialmente para você 🥳 🎉

Aperte os cintos e vamos direto ao ponto:  
Jefferson é o diretor da área de tecnologia de uma multinacional, e teve a ideia de criar um app para **Colher Ideias** de seus funcionários. Ele quer criar um ambiente mais dinâmico e criativo ao seu redor. Para isso, as pessoas terão acesso a aplicação para compartilhar suas ideias, comentar e votar em ideias de outras pessoas.  

Seu objetivo aqui é ajudar *Jeff* a construir a API para a aplicação. Simples 😋

### O escopo: 
- Como usuário *idealizador* tenho permissão para gerir minhas ideias. Nas ideias de outras pessoas, posso somente comentar e votar
- Qualquer usuário pode editar suas infos pessoais
- As ideias passarão por um fluxo de aprovação, onde a cada estágio terá um status específico: nova, em análise, em progresso, implementada, fechada
- Como usuário *administrador*, tenho acesso total a aplicação: usuários, ideias, categorias, papeis, status, etc
- Os endpoints devem ser protegidos com autenticação
- É interessante que, ao removermos uma informação de uma tabela, possamos restaurá-la sempre que possível

### Desafios principais
 - Criar os endpoints CRUD para todas as tabelas (já conseguiu identificá-las?)
 - Criar um endpoint para retornar as ideias com base em filtros: status e categoria
 - Implemente a autenticação com sanctum
 - Implemente também a autorização dos endpoints, conforme o escopo

### Desafios Extras - se quiser fazer um pouquinho mais
- Adicione o campo CPF na tabela de usuários (queremos entender como você fará isso!)
- Utilize resources para retornar as informações nos endpoints GET
- Valide os campos e valores enviados nas requisições (inteiro não é texto, né bebê? 🤪)
- Pagine os endpoints de listagem

### Diferenciais - se quiser SUPERAR as expectativas
- Escreva ao menos 3 testes unitários ou testes de feature (Não precisa inventar moda pra fazer bonito, faça bonito com o que você sabe ;D)
- Implemente uma feature para o upload de uma foto do usuário
- Implemente também um endpoint para busca de ideias por palavra chave
- Já ouviu falar em Service/Repository Pattern? A gente ama! Bora arregaçar as mangas e implementá-lo?
- Queremos acompanhar a evolução do seu desenvolvimento então, não economize nos commits ;)

Ufa... respira... quer tomar uma água ou café?! ☕️

### Como vc será será avaliado
- Organização do código
- Código limpo
- Uso de SOLID
- Capacidade de decisão (vc terá de tomar algumas decisões importantes nesse projeto, queremos entender o por quê)

E..... agora sim. Finalizamos por aqui.  
Faça um fork desse repo, e ao final envie-nos uma PR :D  
Não se esqueça: faça algo que se orgulhe, algo incrível!  

E ah, se tiver dúvidas ou encontrar algum problema, abra uma issue. Estaremos de olho.

Valeu Natalina 🪅🎄  
Beijos e queijos <3
