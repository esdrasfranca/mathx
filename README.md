
# MathX

O MathX é um gerador de exercícios de matemática simples e de código aberto, construído com Laravel. Ele permite que professores e pais criem folhas de exercícios personalizadas para as quatro operações matemáticas básicas: adição, subtração, multiplicação e divisão.

## Funcionalidades

- **Gerador de Exercícios:** Crie folhas de exercícios com um número definido de questões.
- **Operações Aritméticas:** Inclui adição, subtração, multiplicação e divisão.
- **Intervalo de Números Personalizável:** Defina os valores mínimo e máximo para os números nos exercícios.
- **Interface Amigável:** Interface web simples e intuitiva para gerar os exercícios.
- **Opções de Exportação:** Imprima os exercícios diretamente do navegador ou faça o download para uso offline.

## Como Executar o Projeto

Para executar o MathX em seu ambiente de desenvolvimento local, siga estas etapas:

1. **Clone o Repositório:**
   ```bash
   git clone https://github.com/seu-usuario/mathx.git
   cd mathx
   ```

2. **Instale as Dependências:**
   ```bash
   composer install
   npm install
   ```

3. **Configure o Ambiente:**
   - Copie o arquivo `.env.example` para `.env`:
     ```bash
     cp .env.example .env
     ```
   - Gere a chave da aplicação:
     ```bash
     php artisan key:generate
     ```

4. **Inicie o Servidor de Desenvolvimento:**
   ```bash
   php artisan serve
   ```

5. **Acesse a Aplicação:**
   Abra seu navegador e acesse `http://localhost:8000`.

## Licença

Este projeto é um software de código aberto licenciado sob a [Licença MIT](https://opensource.org/licenses/MIT).
