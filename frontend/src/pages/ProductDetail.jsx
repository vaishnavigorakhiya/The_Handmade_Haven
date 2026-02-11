import { useEffect, useState } from 'react'
import { useParams, useNavigate } from 'react-router-dom'

const API = 'http://127.0.0.1:8000/api/products'

export default function ProductDetail() {
  const { slug } = useParams()
  const [product, setProduct] = useState(null)
  const navigate = useNavigate()
  const [color, setColor] = useState('')
  const [size, setSize] = useState('')
  const [text, setText] = useState('')


  useEffect(() => {
    fetch(`${API}/${slug}`)
      .then((res) => res.json())
      .then((data) => setProduct(data))
  }, [slug])

  if (!product) return <p>Loading...</p>

  const colors = product.options.filter((o) => o.type === 'color').map((o) => o.value)
  const sizes = product.options.filter((o) => o.type === 'size').map((o) => o.value)
  const hasText = product.options.some((o) => o.type === 'text')

    if (!color && colors.length) setColor(colors[0])
    if (!size && sizes.length) setSize(sizes[0])

  return (
    <div className="page">
      <div className="hero">
        <img
            src={product.image_url?.startsWith('http') ? product.image_url : `http://127.0.0.1:8000${product.image_url}`}
            alt={product.name}
          style={{ width: '100%', borderRadius: '16px', border: '1px solid #eadbcd' }}
        />
        <div>
          <h1>{product.name}</h1>
          <p>{product.description}</p>
          <p className="price">${(product.price / 100).toFixed(2)}</p>

        <div className="options">
            {colors.length > 0 && (
                <label>
                Color:
                <select value={color} onChange={(e) => setColor(e.target.value)}>
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
                <select value={size} onChange={(e) => setSize(e.target.value)}>
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
                    value={text}
                    onChange={(e) => setText(e.target.value)}
                    placeholder="e.g. Vaishnavi"
                />
                </label>
            )}
        </div>


          <button
                className="btn"
                onClick={() => {
                    const item = {
                    ...product,
                    selected: {
                        color,
                        size,
                        text: hasText ? text : '',
                    },
                    }
                    const saved = JSON.parse(localStorage.getItem('cart') || '[]')
                    localStorage.setItem('cart', JSON.stringify([...saved, item]))
                        navigate('/cart')
                }}
                >
                Add to Cart
            </button>
        
        </div>
      </div>
    </div>
  )
}
