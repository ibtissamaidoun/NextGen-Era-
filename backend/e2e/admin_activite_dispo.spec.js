import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  await page.goto('http://localhost:8080/');
  await page.getByRole('link', { name: 'Connexion' }).click();
  await page.getByPlaceholder('Email').click();
  await page.getByPlaceholder('Email').fill('admin1@gmail.com');
  await page.getByPlaceholder('Mot de passe').click();
  await page.getByPlaceholder('Mot de passe').fill('123456');
  await page.getByRole('button', { name: 'Se connceter' }).click();
  await page.goto('http://localhost:8080/dashboard-admin');
  await page.goto('http://localhost:8080/dashboard-admin/AvailablesActivites');
  await page.getByRole('row', { name: 'programmation informatique Détails' }).getByRole('link').click();
  await page.getByRole('dialog').click();
});
