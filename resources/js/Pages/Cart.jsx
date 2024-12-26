import { Head, Link } from "@inertiajs/react";

const Cart = ({ items }) => {
    return (
        <div className="mx-auto w-[80%]">
            <Head title="Cart" />
            <div className="flex justify-between items-center mb-10">
                <h1 className="text-center text-4xl font-bold mt-10">Cart</h1>
                <Link href={route("home")}>
                    <span className="px-4 py-1 bg-black text-white rounded-md">
                        Home
                    </span>
                </Link>
            </div>

            <div>
                {items.length > 0 ? (
                    items.map((product) => (
                        <div className="flex gap-4" key={product.id}>
                            <p>
                                Product: <strong>{product.product_name}</strong>
                            </p>
                            <p>
                                Price: <strong>{product.price}</strong>
                            </p>
                        </div>
                    ))
                ) : (
                    <p>No products found in cart</p>
                )}
            </div>
        </div>
    );
};

export default Cart;
