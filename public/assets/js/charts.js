// charts.js - tiny SVG-based chart helpers (no external dependencies)
(function () {
  function clear(el) {
    while (el.firstChild) el.removeChild(el.firstChild);
  }

  function createSVG(width, height) {
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('width', '100%');
    svg.setAttribute('height', '100%');
    svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
    svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');
    return svg;
  }

  function drawBarChart(container, data) {
    const W = Math.max(container.clientWidth, 320);
    const H = 260;
    clear(container);
    const svg = createSVG(W, H);

    const padding = { left: 36, right: 12, top: 12, bottom: 36 };
    const innerW = W - padding.left - padding.right;
    const innerH = H - padding.top - padding.bottom;

    const values = data.map(d => Number(d.val) || 0);
    const max = Math.max(1, ...values);
    const barGap = 8;
    const barWidth = Math.max(8, (innerW - (data.length - 1) * barGap) / data.length);

    // y-axis grid and labels
    const ticks = 4;
    for (let i = 0; i <= ticks; i++) {
      const y = padding.top + (innerH * i) / ticks;
      const val = Math.round(max * (1 - i / ticks));
      const line = document.createElementNS(svg.namespaceURI, 'line');
      line.setAttribute('x1', padding.left);
      line.setAttribute('x2', W - padding.right);
      line.setAttribute('y1', y);
      line.setAttribute('y2', y);
      line.setAttribute('stroke', '#eef2f6');
      line.setAttribute('stroke-width', '1');
      svg.appendChild(line);

      const lab = document.createElementNS(svg.namespaceURI, 'text');
      lab.setAttribute('x', 8);
      lab.setAttribute('y', y + 4);
      lab.setAttribute('fill', '#6b7280');
      lab.setAttribute('font-size', '11');
      lab.textContent = val;
      svg.appendChild(lab);
    }

    // bars
    data.forEach((d, i) => {
      const v = Number(d.val) || 0;
      const barH = (v / max) * innerH;
      const x = padding.left + i * (barWidth + barGap);
      const y = padding.top + (innerH - barH);

      const rect = document.createElementNS(svg.namespaceURI, 'rect');
      rect.setAttribute('x', x);
      rect.setAttribute('y', y);
      rect.setAttribute('width', barWidth);
      rect.setAttribute('height', Math.max(0.1, barH));
      rect.setAttribute('fill', '#3b82f6');
      rect.setAttribute('rx', '4');
      svg.appendChild(rect);

      // label
      const lx = x + barWidth / 2;
      const ly = padding.top + innerH + 14;
      const lab = document.createElementNS(svg.namespaceURI, 'text');
      lab.setAttribute('x', lx);
      lab.setAttribute('y', ly);
      lab.setAttribute('fill', '#374151');
      lab.setAttribute('font-size', '11');
      lab.setAttribute('text-anchor', 'middle');
      lab.textContent = d.day || '';
      svg.appendChild(lab);
    });

    container.appendChild(svg);
    // store last data for redraws
    container._chart = { type: 'bar', data };
  }

  function drawLineChart(container, values) {
    const W = Math.max(container.clientWidth, 320);
    const H = 260;
    clear(container);
    const svg = createSVG(W, H);

    const padding = { left: 36, right: 12, top: 12, bottom: 36 };
    const innerW = W - padding.left - padding.right;
    const innerH = H - padding.top - padding.bottom;

    const nums = values.map(v => Number(v) || 0);
    const max = Math.max(1, ...nums);
    const stepX = innerW / Math.max(1, nums.length - 1);

    // grid
    const ticks = 4;
    for (let i = 0; i <= ticks; i++) {
      const y = padding.top + (innerH * i) / ticks;
      const val = Math.round(max * (1 - i / ticks));
      const line = document.createElementNS(svg.namespaceURI, 'line');
      line.setAttribute('x1', padding.left);
      line.setAttribute('x2', W - padding.right);
      line.setAttribute('y1', y);
      line.setAttribute('y2', y);
      line.setAttribute('stroke', '#eef2f6');
      line.setAttribute('stroke-width', '1');
      svg.appendChild(line);

      const lab = document.createElementNS(svg.namespaceURI, 'text');
      lab.setAttribute('x', 8);
      lab.setAttribute('y', y + 4);
      lab.setAttribute('fill', '#6b7280');
      lab.setAttribute('font-size', '11');
      lab.textContent = val;
      svg.appendChild(lab);
    }

    // polyline
    const points = nums.map((n, i) => {
      const x = padding.left + i * stepX;
      const y = padding.top + (innerH - (n / max) * innerH);
      return `${x},${y}`;
    }).join(' ');

    const poly = document.createElementNS(svg.namespaceURI, 'polyline');
    poly.setAttribute('points', points);
    poly.setAttribute('fill', 'none');
    poly.setAttribute('stroke', '#10b981');
    poly.setAttribute('stroke-width', '3');
    poly.setAttribute('stroke-linecap', 'round');
    svg.appendChild(poly);

    // small circles
    nums.forEach((n, i) => {
      const x = padding.left + i * stepX;
      const y = padding.top + (innerH - (n / max) * innerH);
      const c = document.createElementNS(svg.namespaceURI, 'circle');
      c.setAttribute('cx', x);
      c.setAttribute('cy', y);
      c.setAttribute('r', '4');
      c.setAttribute('fill', '#10b981');
      svg.appendChild(c);
    });

    container.appendChild(svg);
    container._chart = { type: 'line', data: values };
  }

  // Public API
  window.renderBarChart = function (el, data) {
    if (!el) return;
    drawBarChart(el, data || []);
    // auto-redraw on resize
    if (window.ResizeObserver) {
      if (!el._ro) {
        el._ro = new ResizeObserver(() => drawBarChart(el, data || []));
        el._ro.observe(el);
      }
    } else {
      // fallback: window resize
      if (!window._chartsResizeHandler) {
        window._chartsResizeHandler = () => document.querySelectorAll('.chart-box').forEach(c => {
          if (c._chart && c._chart.type === 'bar') drawBarChart(c, c._chart.data);
          if (c._chart && c._chart.type === 'line') drawLineChart(c, c._chart.data);
        });
        window.addEventListener('resize', window._chartsResizeHandler);
      }
    }
  };

  window.renderLineChart = function (el, values) {
    if (!el) return;
    drawLineChart(el, values || []);
    if (window.ResizeObserver) {
      if (!el._ro) {
        el._ro = new ResizeObserver(() => drawLineChart(el, values || []));
        el._ro.observe(el);
      }
    }
  };

})();
