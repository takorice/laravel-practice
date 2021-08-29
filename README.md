# laravel-sap-sample

SPA のバックエンドとして Laravel を使う場合における API と、Unit Test の実装サンプルです。  
開発環境にはLaravel Sail、認証には Laravel Sanctum を使用していますので、数分でセットアップが可能です (前提ソフトウェアは別途必要です)。

フロントエンドは Login と Task の CRUD のみ実装しています。  

サンプル実装している API の内容は、Wiki へ記載していく予定です。

なお、phpがインストールされている前提ですが、必要に応じて、`php artisan` を `./vendor/bin/sail artisan` に変更してください (.env の DB_HOST の編集が別途必要です)。


## 技術要素、動作確認バージョン
- Frontend
  - TypeScript 4.3
  - React 17.0
  - Node.js 14.17
  - Ant Design 4.16

- Backend
  - PHP 8.0
  - Laravel 8.4
  - MySQL 8.0


## 開始方法 (MacOS)
#### 前提ソフトウェア
- composer
- Docker Desktop for Mac

#### セットアップコマンド
```bash
# パッケージのインストール
composer install

# Dockerを起動
./vendor/bin/sail up -d

# .env ファイルを作成
cp .env.testing .env

# マイグレーション実行
php artisan migrate:fresh --seed

# サーバ起動
php artisan serve
```

#### 画面の確認
http://127.0.0.1:8000


## その他
#### Laravel IDE Helper を使う
```bash
php artisan ide-helper:generate
php artisan ide-helper:models -M
```

#### フロントエンドの開発セットアップ
- 前提ソフトウェア
  - npm

```bash
# パッケージインストール
npm install

# ビルドの実行
npm prod
```
