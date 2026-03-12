const expressionEl = document.getElementById('expression');
const resultEl = document.getElementById('result');
const historyListEl = document.getElementById('historyList');

let expression = '';
let lastResult = '';
let justEvaluated = false;

const STORAGE_KEY = 'calculator_history_v1';

function updateDisplay() {
  expressionEl.textContent = expression || '0';
  resultEl.textContent = lastResult !== '' ? '= ' + lastResult : '';
}

function safeEval(expr) {
  try {
    if (!expr) return '';
    if (/[\+\-\*\/.]$/.test(expr)) return '';
    const result = Function('"use strict"; return (' + expr + ')')();
    if (!Number.isFinite(result)) return 'Undefined';
    return result.toString();
  } catch {
    return 'Undefined';
  }
}

function appendNumber(num) {
  if (justEvaluated) {
    expression = '';
    lastResult = '';
    justEvaluated = false;
  }

  expression += num;
  lastResult = safeEval(expression);
  updateDisplay();
}

function appendDecimal() {
  if (justEvaluated) {
    expression = '';
    lastResult = '';
    justEvaluated = false;
  }

  const lastPart = expression.split(/[\+\-\*\/\(\)]/).pop();
  if (lastPart.includes('.')) return;

  if (expression === '' || /[\+\-\*\/\(]$/.test(expression)) {
    expression += '0.';
  } else {
    expression += '.';
  }

  lastResult = safeEval(expression);
  updateDisplay();
}

function appendOperator(op) {
  if (expression === '' && op !== '-') return;

  if (justEvaluated) {
    expression = lastResult === 'Undefined' ? '' : lastResult;
    justEvaluated = false;
  }

  if (/[\+\-\*\/]$/.test(expression)) {
    expression = expression.slice(0, -1);
  }

  expression += op;
  lastResult = '';
  updateDisplay();
}

function appendParenthesis(p) {
  if (justEvaluated && p === '(') {
    expression = '';
    lastResult = '';
    justEvaluated = false;
  }

  if (p === '(') {
    if (expression === '' || /[\+\-\*\/\(]$/.test(expression)) {
      expression += '(';
    } else {
      expression += '*(';
    }
  } else {
    const openCount = (expression.match(/\(/g) || []).length;
    const closeCount = (expression.match(/\)/g) || []).length;
    if (openCount > closeCount && !/[\+\-\*\/\(]$/.test(expression)) {
      expression += ')';
    }
  }

  lastResult = safeEval(expression);
  updateDisplay();
}

function appendPercent() {
  if (expression === '') return;
  if (/[\+\-\*\/\(]$/.test(expression)) return;

  expression += '/100';
  lastResult = safeEval(expression);
  updateDisplay();
}

function toggleSign() {
  if (expression === '') {
    expression = '-';
    updateDisplay();
    return;
  }

  if (justEvaluated) {
    if (lastResult && lastResult !== 'Undefined') {
      expression = String(-Number(lastResult));
      lastResult = safeEval(expression);
      justEvaluated = false;
      updateDisplay();
    }
    return;
  }

  if (/^-?\d+(\.\d+)?$/.test(expression)) {
    expression = String(-Number(expression));
  } else {
    expression = '-(' + expression + ')';
  }

  lastResult = safeEval(expression);
  updateDisplay();
}

function deleteLast() {
  if (justEvaluated) {
    justEvaluated = false;
  }

  expression = expression.slice(0, -1);
  lastResult = safeEval(expression);
  updateDisplay();
}

function clearAll() {
  expression = '';
  lastResult = '';
  justEvaluated = false;
  updateDisplay();
}

function useResult() {
  if (lastResult && lastResult !== 'Undefined') {
    expression = lastResult;
    justEvaluated = false;
    updateDisplay();
  }
}

function getHistory() {
  const history = localStorage.getItem(STORAGE_KEY);
  return history ? JSON.parse(history) : [];
}

function saveHistory(history) {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(history));
}

function addToHistory(expr, result) {
  if (!expr || result === '' || result === 'Undefined') return;

  const history = getHistory();
  history.unshift({ expression: expr, result: result });

  if (history.length > 20) {
    history.pop();
  }

  saveHistory(history);
  renderHistory();
}

function renderHistory() {
  const history = getHistory();
  historyListEl.innerHTML = '';

  if (history.length === 0) {
    historyListEl.innerHTML = '<div class="empty-history">No calculations yet</div>';
    return;
  }

  history.forEach(item => {
    const div = document.createElement('div');
    div.className = 'history-item';
    div.innerHTML = `
      <div class="history-expression">${item.expression}</div>
      <div class="history-result">= ${item.result}</div>
    `;

    div.addEventListener('click', () => {
      expression = item.expression;
      lastResult = item.result;
      justEvaluated = false;
      updateDisplay();
    });

    historyListEl.appendChild(div);
  });
}

function clearHistory() {
  localStorage.removeItem(STORAGE_KEY);
  renderHistory();
}

function calculateResult() {
  const result = safeEval(expression);

  if (result === '') return;

  lastResult = result;
  justEvaluated = true;
  updateDisplay();

  addToHistory(expression, result);
}

document.addEventListener('keydown', (e) => {
  const key = e.key;

  if (/[0-9]/.test(key)) {
    appendNumber(key);
  } else if (key === '.') {
    appendDecimal();
  } else if (['+', '-', '*', '/'].includes(key)) {
    appendOperator(key);
  } else if (key === 'Enter' || key === '=') {
    e.preventDefault();
    calculateResult();
  } else if (key === 'Backspace') {
    deleteLast();
  } else if (key === 'Escape') {
    clearAll();
  } else if (key === '(' || key === ')') {
    appendParenthesis(key);
  } else if (key === '%') {
    appendPercent();
  }
});

updateDisplay();
renderHistory();
