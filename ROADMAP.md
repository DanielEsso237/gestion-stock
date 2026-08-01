# Roadmap — SaaS Gestion de Stock (Laravel + Blade + Alpine.js)

Projet portfolio : application de gestion de stock multi-boutiques pour gérants.
Chaque étape ci-dessous correspond à un ou plusieurs commits, pour garder un historique Git propre et lisible.

Convention de commit : [Conventional Commits](https://www.conventionalcommits.org/)
`feat:`, `fix:`, `chore:`, `refactor:`, `test:`, `docs:`, `style:`

---

## Phase 0 — Setup du projet
- [ ] `chore: initial Laravel skeleton` — création projet + git init + repo GitHub
- [ ] `chore: configure database connection` — config .env (SQLite en dev)
- [ ] `docs: add README with project description`

## Phase 1 — Authentification & multi-tenant
- [ ] `feat: add authentication with Laravel Breeze`
- [ ] `feat: add Boutique model and migration`
- [ ] `feat: link user to boutique (tenant relationship)`
- [ ] `feat: add global scope for tenant data isolation`
- [ ] `feat: add boutique switcher for users with multiple boutiques`

## Phase 2 — Gestion des produits
- [ ] `feat: add Categorie model and migration`
- [ ] `feat: add Produit model and migration`
- [ ] `feat: add produit index page with search and filters`
- [ ] `feat: add create produit form`
- [ ] `feat: add edit produit form`
- [ ] `feat: add delete produit action`

## Phase 3 — Gestion des mouvements de stock
- [ ] `feat: add MouvementStock model and migration`
- [ ] `feat: add stock entry (réception marchandise)`
- [ ] `feat: add stock exit (vente, perte, casse)`
- [ ] `feat: add stock movement history per produit`
- [ ] `feat: auto-update produit quantity on movement`

## Phase 4 — Dashboard & alertes
- [ ] `feat: add dashboard with key metrics`
- [ ] `feat: add low-stock alert system`
- [ ] `feat: add email notification for low stock`

## Phase 5 — Rapports & exports
- [ ] `feat: add stock value report`
- [ ] `feat: add CSV export for produits`
- [ ] `feat: add PDF export for stock report`

## Phase 6 — Finitions & qualité
- [ ] `test: add feature tests for produit CRUD`
- [ ] `test: add feature tests for stock movements`
- [ ] `style: polish UI with Tailwind`
- [ ] `docs: add deployment guide`
- [ ] `chore: setup CI (GitHub Actions - tests on push)`

---

## Stack technique
- Laravel 11 (dernière version stable)
- Blade + Alpine.js + Tailwind CSS
- Laravel Breeze (auth)
- SQLite en dev, MySQL/PostgreSQL en prod
- Pest ou PHPUnit pour les tests