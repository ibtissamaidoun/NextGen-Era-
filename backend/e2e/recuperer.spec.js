import { test, expect } from '@playwright/test';

test('testCorrecte', async ({ page }) => {
  await page.goto('http://localhost:8080/');
  await page.getByRole('link', { name: 'Connexion' }).click();
  await page.getByRole('link', { name: 'Mot de passe oublié' }).click();
  await page.getByPlaceholder('Email').click();
  await page.getByPlaceholder('Email').fill('boussaidmeryeme@gmail.com');
  await page.getByRole('button', { name: 'Récupérer' }).click();
  await page.goto('http://localhost:8080/forget');
  await page.goto('http://localhost:8080/reset');
  await page.getByPlaceholder('Mot de passe', { exact: true }).click();
  await page.getByPlaceholder('Mot de passe', { exact: true }).fill('123456');
  await page.getByPlaceholder('Confirmez le mot de passe').click();
  await page.getByPlaceholder('Confirmez le mot de passe').fill('123456');
  await page.getByRole('link', { name: 'Rénitialiser' }).click();
});
test('testincorrecte', async ({ page }) => {
    await page.goto('http://localhost:8080/');
    await page.getByRole('link', { name: 'Connexion' }).click();
    await page.getByRole('link', { name: 'Mot de passe oublié' }).click();
    await page.getByPlaceholder('Email').click();
    await page.getByPlaceholder('Email').fill('boussaidmeryeme@gmail.com');
    await page.getByRole('button', { name: 'Récupérer' }).click();
    await page.goto('http://localhost:8080/forget');
    await page.goto('http://localhost:8080/reset');
    await page.getByPlaceholder('Mot de passe', { exact: true }).click();
    await page.getByPlaceholder('Mot de passe', { exact: true }).fill('123456');
    await page.getByPlaceholder('Confirmez le mot de passe').click();
    await page.getByPlaceholder('Confirmez le mot de passe').fill('1234567');
    await page.getByRole('link', { name: 'Rénitialiser' }).click();
  });
