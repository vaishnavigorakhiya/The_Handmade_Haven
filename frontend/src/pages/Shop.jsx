import { useEffect, useState } from 'react'
import { Link, useNavigate} from 'react-router-dom'
import '../styles/Shop.css'

const API = 'http://127.0.0.1:8000/api'
const PRODUCTS = `${API}/products`

export default function Shop() {
  const [products, setProducts] = useState([])
  const [custom, setCustom] = useState({})
  const [loading, setLoading] = useState(true)
  const navigate = useNavigate()


  useEffect(() => {
    fetch(PRODUCTS, { credentials: 'include' })
      .then((res) => res.json())
      .then((data) => {
        setProducts(data)
        setLoading(false)
      })
  }, [])

  const getOptions = (product, type) =>
    product.options.filter((o) => o.type === type).map((o) => o.value)

  const setOption = (productId, key, value) => {
    setCustom((prev) => ({
      ...prev,
      [productId]: { ...prev[productId], [key]: value },
    }))
  }

  const addToCart = (product) => {
    const colors = getOptions(product, 'color')
    const sizes = getOptions(product, 'size')
    const hasText = getOptions(product, 'text').length > 0

    const c = custom[product.id] || {}
    const item = {
      ...product,
      selected: {
        color: c.color || colors[0],
        size: c.size || sizes[0],
        text: hasText ? c.text || '' : '',
      },
    }

    const saved = JSON.parse(localStorage.getItem('cart') || '[]')
    const updated = [...saved, item]
    localStorage.setItem('cart', JSON.stringify(updated))
    navigate('/cart')
  }


  if (loading) return <p>Loading products...</p>

  return (
    <div className="page">
      <h1>Shop</h1>
      <main className="layout">
        <section className="product-grid">
          {products.map((p) => {
            const colors = getOptions(p, 'color')
            const sizes = getOptions(p, 'size')
            const hasText = getOptions(p, 'text').length > 0

            return (
              <article key={p.id} className="card product-card">
                <div className="image-wrap">
                  <img
                    src={
                      p.image_url?.startsWith('http')
                        ? p.image_url
                        : `http://127.0.0.1:8000${p.image_url}`
                    }
                    alt={p.name}
                  />
                  <span className="badge">Handcrafted</span>
                </div>

                <h3>
                  <Link to={`/product/${p.slug}`}>{p.name}</Link>
                </h3>

                <p>{p.description}</p>

                <div className="options">
                  {colors.length > 0 && (
                    <label>
                      Color:
                      <select
                        value={custom[p.id]?.color || colors[0]}
                        onChange={(e) => setOption(p.id, 'color', e.target.value)}
                      >
                        {colors.map((c) => (
                          <option key={c} value={c}>
                            {c}
                          </option>
                        ))}
                      </select>
                    </label>
                  )}

                  {sizes.length > 0 && (
                    <label>
                      Size:
                      <select
                        value={custom[p.id]?.size || sizes[0]}
                        onChange={(e) => setOption(p.id, 'size', e.target.value)}
                      >
                        {sizes.map((s) => (
                          <option key={s} value={s}>
                            {s}
                          </option>
                        ))}
                      </select>
                    </label>
                  )}

                  {hasText && (
                    <label>
                      Custom text:
                      <input
                        value={custom[p.id]?.text || ''}
                        onChange={(e) => setOption(p.id, 'text', e.target.value)}
                        placeholder="e.g. Vaishnavi"
                      />
                    </label>
                  )}
                </div>

                <div className="card-row">
                  <div className="price">${(p.price / 100).toFixed(2)}</div>
                  <button className="btn" onClick={() => addToCart(p)}>
                    Add to cart
                  </button>
                </div>
              </article>
            )
          })}
        </section>
      </main>
    </div>
  )

}
