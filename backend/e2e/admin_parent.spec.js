import { test, expect } from '@playwright/test';

test('testdetaille', async ({ page }) => {
  await page.goto('http://localhost:8080/');
  await page.getByRole('link', { name: 'Connexion' }).click();
  await page.getByPlaceholder('Email').click();
  await page.getByPlaceholder('Email').fill('marwa@gmail.com');
  await page.getByPlaceholder('Mot de passe').click();
  await page.getByPlaceholder('Mot de passe').fill('123456@');
  await page.getByPlaceholder('Mot de passe').click();
  await page.getByRole('form').locator('i').click();
  await page.getByPlaceholder('Mot de passe').click();
  await page.getByPlaceholder('Mot de passe').fill('12345@');
  await page.getByRole('button', { name: 'Se connceter' }).click();
  await page.getByRole('link', { name: ' Parents' }).click();
  await page.getByText('Détails').nth(1).click();

});

test('testsupprimer', async ({ page }) => {
  await page.goto('http://localhost:8080/');
  await page.goto('http://localhost:8080/login');
  await page.goto('http://localhost:8080/dashboard-admin');
  await page.goto('http://localhost:8080/dashboard-admin/Parents');
});
