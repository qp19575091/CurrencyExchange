

------------
Installation
------------

```
git clone https://github.com/qp19575091/CurrencyExchange.git
```
```
cd CurrencyExchange
```
```
git checkout master
```
```
docker compose up --build
```
```
cp .env.example .env
```
```
docker exec -it CurrencyExchange bash
```
```
composer install
```
```
php artisan key:generate
```

### Example endpoint
```
http://127.0.0.1:8000/api/currencyExchange?source=USD&target=JPY&amount=1,525
```
