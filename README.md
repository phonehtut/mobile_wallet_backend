# Mobile Wallet Back-end with Laravel

## Setup

```shell
docker compose up -d --build
```

```shell
cp .env.example .env
```

```shell
sail artisan key:generate
```

```shell
sail artisan migrate --seed
```

Open http://localhost:8000

- api docs - http://localhost:8000/docs/api


