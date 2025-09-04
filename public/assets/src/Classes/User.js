import Account from "./Account.js";
import Utility from "./Utility.js";
import {Authentication} from "./Authentication.js";

class User {
  constructor() {
    this.initialize();
  }

  async initialize() {
    await AppInit.initializeData();
    Utility.runClassMethods(this, ["initialize"]);
  }

  userLogin() {
    const loginForm = document.getElementById("loginForm");
    if (!loginForm) return;
    const auth = new Authentication();
   
  }
}
