#include <eosiolib/eosio.hpp>

using namespace eosio;
using namespace std;

class[[eosio::contract]] hello : public eosio::contract
{

private:
  struct [[eosio::table]] users_struct
  {
    name name;
    uint16_t reward_points = 0;

    uint64_t primary_key() const { return name.value; }
  };

  typedef eosio::multi_index<"users"_n, users_struct> users_table;

public:
  hello(name receiver, name code, datastream<const char *> ds) : contract(receiver, code, ds){};

  [[eosio::action]] void login(name user) {
    // Ensure this action is authorized by the player
    require_auth(user);

    // Create a record in the table if the player doesn't exist in our app yet
    users_table _users(_code, _code.value);
    auto user_iterator = _users.find(user.value);
    if (user_iterator == _users.end())
    {
      user_iterator = _users.emplace(user, [&](auto &new_user) {
        new_user.name = user;
      });
    }
    else
    {
      _users.modify(user_iterator, user, [&](auto &row) {
        row.reward_points = row.reward_points + 1;
      });
    }
  }
};

void token::transfer( account_name from,
                      account_name to,
                      asset        quantity,
                      string       memo )
{
    eosio_assert( from != to, "cannot transfer to self" );
    require_auth( from );
    eosio_assert( is_account( to ), "to account does not exist");
    auto sym = quantity.symbol.name();
    stats statstable( _self, sym );
    const auto& st = statstable.get( sym );

    require_recipient( from );
    require_recipient( to );

    eosio_assert( quantity.is_valid(), "invalid quantity" );
    eosio_assert( quantity.amount > 0, "must transfer positive quantity" );
    eosio_assert( quantity.symbol == st.supply.symbol, "symbol precision mismatch" );
    eosio_assert( memo.size() <= 256, "memo has more than 256 bytes" );


    sub_balance( from, quantity );
    add_balance( to, quantity, from );
}

EOSIO_DISPATCH(hello, (login))