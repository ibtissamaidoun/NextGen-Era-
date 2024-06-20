import { test, expect } from '@playwright/test';

test('testdetaille', async ({ page }) => {
  await page.goto('http://localhost:8080/');
  await page.getByRole('link', { name: 'Connexion' }).click();
  await page.getByPlaceholder('Email').click();
  await page.getByPlaceholder('Email').fill('marwa@gmail.com');
  await page.getByPlaceholder('Mot de passe').click();
  await page.getByPlaceholder('Mot de passe').fill('12345@');
  await page.getByRole('button', { name: 'Se connceter' }).click();
  await page.getByRole('link', { name: ' Activités' }).click();
  await page.getByRole('row', { name: '9 Formation en design' }).getByRole('link').nth(1).click();
});
