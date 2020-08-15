![screen_shot](https://user-images.githubusercontent.com/53022680/85478534-64264280-b5f7-11ea-918e-e7c05b1c937f.png)
# Culturist
#### 写真や音楽といった芸術作品をお互いにシェアできる、SNS型の写真、音楽共有サイトです。
#### URL: [https://culturist.work](https://culturist.work)
## 使用言語、フレームワーク
- PHP 7.4.8
- Laravel 7.0
- Vue.js. 2.5.17
- Vuex 3.2.0
- Vue Router 3.1.6
- Vuetify 2.2.20
## インフラ
AWS(VPC, EC2, RDS, S3, Route53)
## 開発環境
Docker, docker-compose
## 機能一覧
### ユーザ関連
- 新規登録、ログイン、ログアウト機能
- プロフィール編集機能（プロフィール写真、カバー写真、紹介文等）
- プロフィール表示機能
- 退会（アカウント削除）機能
- 他ユーザフォロー
### 写真、音楽関連
- 投稿機能
- 投稿編集機能
- 投稿削除機能
- 新規投稿一覧取得機能
- 写真詳細表示機能
- 音楽再生機能
- いいねした投稿一覧取得機能
- いいね機能
- フォロー中のユーザの投稿一覧取得機能
### 検索関連
- あいまい検索(LIKE句)
- ユーザ、写真、音楽それぞれに対する検索結果の表示
## 工夫した点
- Ajaxを用いたREST API
- クエリのN+1問題への配慮
- Fat Controller, Fat Modelへの対処
- Traitを利用した共通処理の切り出し
- Vuexによる認証状態の保持、認証状態取得API
- SPA化(Single Page Application)によるUXの向上
- APIテスト
