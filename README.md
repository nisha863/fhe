# Gawa ni Sir Kenn at yung isa pang kupal
<p align="center">simple web app para sa FHE form so that instead of using too many paper. with database integretion for easy filtering and search for that student.</p>

### Tech Used
- [SvelteKit](https://svelte.dev/) - a frontend js framework, lightwieght alternative for react
- php  - used for bridging js to xamp
- mysql (xampp) - for database 
- node js - for running and installing svelteKit

## Installation
>first install [Git here](https://git-scm.com/downloads/win) and [node js here](https://nodejs.org/en/download)

cd to desired folder or open powershell to that folder and paste the following:
```
git clone https://github.com/nisha863/fhe.git
cd fhe
npm install
```
## running
cd to the cloned folder and do:
``` 
npm run dev
```
this will run vite that show sveltekit in http://localhost:5173/ or just press "o" and enter in the terminal after vite is running
## npm package used
| Package   | Version | Description |
|-----------|---------|-------------|
| [pdf-lib](https://www.npmjs.com/package/pdf-lib) | ![npm](https://img.shields.io/npm/v/pdf-lib) | PDf Maker |
| [Signature Pad](https://www.npmjs.com/package/signature_pad) | ![npm](https://img.shields.io/npm/v/signature_pad) | Signature Taker|
| [mysql2](https://www.npmjs.com/package/mysql2) | ![npm](https://shields.io/npm/v/mysql2)| Database handling |

# fixing common problems
### the database
- import [the sql](https://github.com/nisha863/fhe/blob/main/fhe_db.sql) as database



