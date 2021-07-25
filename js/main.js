
'usestrict';
{
const hidden_news = document.getElementById('hidden_news');
const btn = document.getElementById('btn');
btn.addEventListener('click', () => { hidden_news.style.display === 'none' ? hidden_news.style.display = 'block' : hidden_news.style.display = 'none'; });
}
