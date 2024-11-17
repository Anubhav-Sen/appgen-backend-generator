"""test

Revision ID: d3fab35181b6
Revises: 4439499f8c95
Create Date: 2024-11-17 04:27:35.908133

"""
from typing import Sequence, Union

from alembic import op
import sqlalchemy as sa
import sqlmodel


# revision identifiers, used by Alembic.
revision: str = 'd3fab35181b6'
down_revision: Union[str, None] = '4439499f8c95'
branch_labels: Union[str, Sequence[str], None] = None
depends_on: Union[str, Sequence[str], None] = None


def upgrade() -> None:
    pass


def downgrade() -> None:
    pass
