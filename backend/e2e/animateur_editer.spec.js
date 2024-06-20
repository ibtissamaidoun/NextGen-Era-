import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  await page.goto('http://localhost:8080/');
  await page.getByRole('link', { name: 'Connexion' }).click();
  await page.getByPlaceholder('Email').click();
  await page.getByPlaceholder('Email').fill('animateur@example.com');
  await page.getByPlaceholder('Mot de passe').click();
  await page.getByPlaceholder('Mot de passe').fill('123456');
  await page.getByRole('button', { name: 'Se connceter' }).click();
  await page.getByRole('row', { name: ':00:00 22:00:00 Mercredi' }).getByRole('link').click();
  await page.getByPlaceholder('Heure de début').click();
  await page.getByPlaceholder('Heure de début').fill('20:00:00');
  await page.getByPlaceholder('Heure de la fin').click();
  await page.getByPlaceholder('Heure de la fin').fill('21:00:00');
  await page.getByPlaceholder('Jour de semaine').click();
  await page.getByPlaceholder('Jour de semaine').fill('Mardi');
  await page.getByRole('button', { name: 'Editer' }).click();
});
