function login(){
//atribuindo valores para os inputs
const usuario = document.getElementById('usuario').value;
const senha = document.getElementById('senha').value; 

if(!usuario || !senha){
    alert('Por favor, preencha todos os campos.');
    return;
}
//recuperar a lista de usuarios cadastrados
let usuarios = JSON.parse(localStorage.getItem('usuarios')) || [];

//verificar se o usuario existe e a senha esta correta
const usuarioEncontrado = usuarios.find(u => u.login === usuario && u.senha === senha); 
if(usuarioEncontrado){
    alert('Login bem-sucedido! Bem-vindo, ' + usuarioEncontrado.login + '!');
    window.location.href = 'outras paginas/portifolio.html'
}
else{
    alert('Usuário ou senha incorretos. Por favor, tente novamente.');
}
}

function cadastrar(){
    const usuario = document.getElementById('usuario').value; 
    const senha = document.getElementById('senha').value; 
    const confirmacaoSenha = document.getElementById('confirmacaoSenha').value; 

    if(!usuario || !senha || !confirmacaoSenha){
        alert('Por favor, preencha todos os campos.');
        return;
    }
    if(senha !== confirmacaoSenha){
        alert('As senhas não coincidem. Por favor, tente novamente.');
        return;
    } 
    
    //lista de usuarios cadastrados
    let usuarios = JSON.parse(localStorage.getItem('usuarios')) || []; //Primeiro eu crio uma variavel que guarda todos os usuarios e tendo atribuir um valor do item usuarios, convertendo antes para JSON. Como usuarios esta null, ele cria um array vazio para armazenar os usuarios.
    
    //verificar se o nome de usuário já existe
    const existe = usuarios.find(u => u.login === usuario); // eu uso uma função do array find para achar um usuario que tenho o login igual ao que o usuario digitou. Se encontrar, a variavel existe vai receber esse usuario, caso contrario, ela vai ser undefined.
    //obs: o find retorna o valor achado ou null, ent usar => nao vai ser true ou false e sim o valor ou null.

    if(existe){
        alert('Usuário já existe. Por favor, escolha outro nome de usuário.');
        return;
    }

    //criar um objeto para o usuario 

    let novoUsuario = {
        login: usuario,
        senha: senha
    };
    usuarios.push(novoUsuario); //adiciona o novo usuario ao array de usuarios
    localStorage.setItem('usuarios', JSON.stringify(usuarios)) //salva o array de usuarios atualizado no localStorage, convertendo-o para uma string JSON antes de armazenar

    alert('Cadastro realizado com sucesso! Agora você pode fazer login.');
}
//Terminei o cadastro !!!!!