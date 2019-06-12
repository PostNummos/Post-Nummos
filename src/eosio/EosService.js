import { Api, JsonRpc } from 'eosjs';
import ScatterJS from 'scatterjs-core';
import ScatterEOS from 'scatterjs-plugin-eosjs2';

const endpoint = 'https://api.kylin.alohaeos.com:443'; // kylin
const network = {
  blockchain: 'eos',
  protocol: 'https',
  host: 'api.kylin.alohaeos.com',
  port: 443,
  chainId: '5fff1dae8dc8e2fc4d5b23b2c7665c97f9e9d8edf2b6485a86ba311c25639191'
};

class EosService {
  constructor(dappName, contractAccount) {
    this.dappName = dappName;
    this.contractAccount = contractAccount;
    ScatterJS.plugins(new ScatterEOS());
    this.rpc = new JsonRpc(endpoint);
    window.ScatterJS = null;
  }

  connect = async () => {
    await ScatterJS.scatter.connect(this.dappName).then(connected => {
      if (!connected) return console.log('Failed to connect with Scatter!');
      this.scatter = ScatterJS.scatter;
    });

    await this.scatter.getIdentity({ accounts: [network] }).then(() => {
      this.account = this.scatter.identity.accounts.find(
        e => e.blockchain === 'eos'
      );
    });

    if (this.account === null) return false;

    return true;
  };

  transaction = async (action, data) => { 
    this.api = this.scatter.eos(network, Api, { rpc: this.rpc });

    const resultWithConfig = await this.api.transact(
      {
        actions: [
          {
            account: this.contractAccount,
            name: action,
            authorization: [
              {
                actor: this.account.name,
                permission: this.account.authority
              }
            ],
            data: {
              ...data
            }
          }
        ]
      },
      {
        blocksBehind: 3,
        expireSeconds: 30
      }
    );
    console.log(resultWithConfig);
    return true;
  };

transaction2 = async (action, data) => { 
    this.api = this.scatter.eos(network, Api, { rpc: this.rpc });
    const resultWithConfig = await this.api.transaction({
          actions: [
          {
              account: "youraccname1", //has to be the smart contract name of the token you want to transfer - eosio for EOS or eosjackscoin for JKR for example
              name: "transfer",
              authorization: [{
                  actor: this.account.name,
                  permission: this.account.authority
              }
              ],
              data: {
                  from: this.account.name,
                  to: "testproheife",
                  quantity: "50.0000 EOS",
                  memo: ""
              }
          }]
      });
    //console.log(resultWithConfig);
    return true;
  };
/*
  transferToken = async()=>{
    this.api = this.scatter.eos(network, Api, { rpc: this.rpc });
    const transactionOptions = { authorization:[`${this.account.name}@${this.account.authority}`] };
    const resultWithConfig = await this.api.transfer(this.account.name,'testproheife', '10.0000 EOS', '', {authorization: [
              {
                actor: this.account.name,
                permission: this.account.authority
              }
            ]});
    console.log(resultWithConfig);
  }
  

  
  transferToken = async api => {
    try {
      const from = this.scatter.account('eos');
      const result = await this.api.transact({
        actions: [{
          account: 'eosio.token',
          name: 'transfer',
          authorization: [{
            actor: from.name,
            permission: from.authority,
          }],
          data: {
            from: from.name,
            to: 'safetransfer',
            quantity: '0.0001 EOS',
            memo: from.name,
          },
        }]
      }, {
        blocksBehind: 3,
        expireSeconds: 30,
      });
      console.log('result', result);
    } catch (e) {
      console.error(e);
    }
  };
*/
  
}

export default EosService;
